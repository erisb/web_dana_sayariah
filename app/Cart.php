<?php

namespace App;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Database\DatabaseManager;
use App\Interfaces\Investable;

class Cart
{
    const DEFAULT_INSTANCE = 'default';

    private $session;
    private $instance;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
        $this->instance(self::DEFAULT_INSTANCE);
    }

    public function instance($instance = null)
    {
        $instance = $instance ? : self::DEFAULT_INSTANCE;
        $this->instance = sprintf('%s.%s', 'cart', $instance);
        return $this;
    }

    public function currentInstance()
    {
        return str_replace('cart.', '', $this->instance);
    }

    public function add($id, $name = null, $qty = null, $price = null)
    {
        if ($this->isArray($id)) {
            return array_map(function ($item) {
                return $this->add($item);
            }, $id);
        }

        $cartItem = $this->createCartItem($id, $name, $qty, $price);
        $content = $this->getContent();
        if ($content->has($cartItem->rowId)) {
            $cartItem->qty += $content->get($cartItem->rowId)->qty;
        }
        $content->put($cartItem->rowId, $cartItem);

        $this->session->put($this->instance, $content);

        return $cartItem;
    }

    private function isArray($item)
    {
        if (!is_array($item))
            return false;

        return is_array(head($item)) || head($item) instanceof Investable;
    }

    public function update($rowId, $qty)
    {
        $cartItem = $this->get($rowId);

        if ($qty instanceof Investable) {
            $cartItem->updateFromInvestable($qty);
        } elseif (is_array($qty)) {
            $cartItem->updateFromArray($qty);
        } else {
            $cartItem->qty = $qty;
        }

        $content = $this->getContent();

        if ($rowId !== $cartItem->rowId) {
            $content->pull($rowId);

            if ($content->has($cartItem->rowId)) {
                $existingCartItem = $this->get($cartItem->rowId);
                $cartItem->setQuantity($existingCartItem->qty + $cartItem->qty);
            }
        }

        if ($cartItem->qty <= 0) {
            $this->remove($cartItem->rowId);
            return;
        } else {
            $content->put($cartItem->rowId, $cartItem);
        }

        $this->session->put($this->instance, $content);

        return $cartItem;
    }

    public function remove($rowId)
    {
        $cartItem = $this->get($rowId);

        $content = $this->getContent();

        $content->pull($cartItem->rowId);

        $this->session->put($this->instance, $content);
    }

    public function get($rowId)
    {
        $content = $this->getContent();

        if (!$content->has($rowId))
            throw new InvalidRowIDException("The cart does not contain rowId {$rowId}.");

        return $content->get($rowId);
    }

    public function destroy()
    {
        $this->session->remove($this->instance);
    }

    public function content()
    {
        if (is_null($this->session->get($this->instance))) {
            return new Collection([]);
        }

        return $this->session->get($this->instance);
    }

    public function count()
    {
        $content = $this->getContent();

        return $content->sum('qty');
    }

    public function total($decimals = null, $decimalPoint = null, $thousandSeperator = null)
    {
        $content = $this->getContent();

        $total = $content->reduce(function ($total, CartItem $cartItem) {
            return $total + ($cartItem->qty * $cartItem->price);
        }, 0);

        return $this->numberFormat($total, $decimals, $decimalPoint, $thousandSeperator);
    }

    public function associate($rowId, $model)
    {
        if (is_string($model) && !class_exists($model)) {
            throw new UnknownModelException("The supplied model {$model} does not exist.");
        }

        $cartItem = $this->get($rowId);
        $cartItem->associate($model);
        $content = $this->getContent();
        $content->put($cartItem->rowId, $cartItem);
        $this->session->put($this->instance, $content);
    }

    /**
     * Save cart
     */
    public function store($identifier)
    {
        $content = $this->getContent();

        if ($this->storedCartWithIdentifierExists($identifier)) {
            throw new CartAlreadyStoredException("A cart with identifier {$identifier} was already stored.");
        }

        $this->getConnection()->table($this->getTableName())->insert([
            'identifier' => $identifier,
            'instance' => $this->currentInstance(),
            'content' => serialize($content)
        ]);
    }

    /**
     * Restore cart
     */
    public function restore($identifier)
    {
        if (!$this->storedCartWithIdentifierExists($identifier)) {
            return;
        }

        $stored = $this->getConnection()->table($this->getTableName())
            ->where('identifier', $identifier)->first();

        $storedContent = unserialize($stored->content);

        $currentInstance = $this->currentInstance();

        $this->instance($stored->instance);

        $content = $this->getContent();

        foreach ($storedContent as $cartItem) {
            $content->put($cartItem->rowId, $cartItem);
        }

        $this->session->put($this->instance, $content);

        $this->instance($currentInstance);

        $this->getConnection()->table($this->getTableName())
            ->where('identifier', $identifier)->delete();
    }

    public function __get($attribute)
    {
        if ($attribute === 'total') {
            return $this->total();
        }
    }

    protected function getContent()
    {
        $content = $this->session->has($this->instance) ? $this->session->get($this->instance) : new Collection;

        return $content;
    }

    private function createCartItem($id, $name, $qty, $price)
    {
        if ($id instanceof Investable) {
            $cartItem = CartItem::fromInvestable($id, $qty ? : []);
            $cartItem->setQuantity($name ? : 1);
            $cartItem->associate($id);
        } elseif (is_array($id)) {
            $cartItem = CartItem::fromArray($id);
            $cartItem->setQuantity($id['qty']);
        } else {
            $cartItem = CartItem::fromAttributes($id, $name, $price);
            $cartItem->setQuantity($qty);
        }

        return $cartItem;
    }

    private function storedCartWithIdentifierExists($identifier)
    {
        return $this->getConnection()->table($this->getTableName())->where('identifier', $identifier)->exists();
    }

    private function getTableName()
    {
        return 'shoppingcart';
    }

    private function getConnection()
    {
        return app(DatabaseManager::class)->connection(config('database.default'));
    }

    private function numberFormat($value, $decimals, $decimalPoint, $thousandSeperator)
    {
        if (is_null($decimals)) {
            $decimals = 0;
        }
        if (is_null($decimalPoint)) {
            $decimalPoint = ',';
        }
        if (is_null($thousandSeperator)) {
            $thousandSeperator = '.';
        }

        return number_format($value, $decimals, $decimalPoint, $thousandSeperator);
    }

}
