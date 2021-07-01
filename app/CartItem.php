<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use App\Interfaces\Investable;

class CartItem implements Arrayable, Jsonable
{
    public $rowId;
    public $id;
    public $qty;
    public $name;
    public $price;

    public function __construct($id, $name, $price)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Please supply a valid ID.');
        }
        if (empty($name)) {
            throw new \InvalidArgumentException('Please supply a valid name.');
        }
        if (strlen($price) < 0 || !is_numeric($price)) {
            throw new \InvalidArgumentException('Please supply a valid price.');
        }

        $this->id = $id;
        $this->name = $name;
        $this->price = floatval($price);
        $this->rowId = $this->generateRowId($id);
    }

    public function price($decimals = null, $decimalPoint = null, $thousandSeperator = null)
    {
        return $this->numberFormat($this->price, $decimals, $decimalPoint, $thousandSeperator);
    }

    public function total($decimals = null, $decimalPoint = null, $thousandSeperator = null)
    {
        return $this->numberFormat($this->total, $decimals, $decimalPoint, $thousandSeperator);
    }

    public function setQuantity($qty)
    {
        if (empty($qty) || !is_numeric($qty))
            throw new \InvalidArgumentException('Please supply a valid quantity.');

        $this->qty = $qty;
    }

    public function updateFromInvestable(Investable $item)
    {
        $this->id = $item->getInvestableIdentifier();
        $this->name = $item->getInvestableDescription();
        $this->price = $item->getInvestablePrice();
    }

    public function updateFromArray(array $attributes)
    {
        $this->id = array_get($attributes, 'id', $this->id);
        $this->qty = array_get($attributes, 'qty', $this->qty);
        $this->name = array_get($attributes, 'name', $this->name);
        $this->price = array_get($attributes, 'price', $this->price);

        $this->rowId = $this->generateRowId($this->id);
    }

    public function associate($model)
    {
        $this->associatedModel = is_string($model) ? $model : get_class($model);

        return $this;
    }

    public function __get($attribute)
    {
        if (property_exists($this, $attribute)) {
            return $this->{$attribute};
        }

        if ($attribute === 'total') {
            return $this->qty;
        }

        if ($attribute === 'subprice') {
            return ($this->qty * $this->price);
        }

        if ($attribute === 'model' && isset($this->associatedModel)) {
            return with(new $this->associatedModel)->find($this->id);
        }

        return null;
    }

    public static function fromInvestable(Investable $item)
    {
        return new self($item->getInvestableIdentifier(), $item->getInvestableDescription(), $item->getInvestablePrice());
    }

    public static function fromArray(array $attributes)
    {
        return new self($attributes['id'], $attributes['name'], $attributes['price']);
    }

    public static function fromAttributes($id, $name, $price)
    {
        return new self($id, $name, $price);
    }

    /**
     * Generate a unique id for the cart item (?) Or should i use the same identifiers for CartItem on every users?
     */
    protected function generateRowId($id)
    {
        // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $charactersLength = strlen($characters);
        // $randomString = '';
        // for ($i = 0; $i < 10; $i++) {
        //     $randomString .= $characters[rand(0, $charactersLength - 1)];
        // }
        // return md5(serialize($id . $randomString));
        return md5($id);
    }

    public function toArray()
    {
        return [
            'rowId' => $this->rowId,
            'id' => $this->id,
            'name' => $this->name,
            'qty' => $this->qty,
            'price' => $this->price,
            'total' => $this->total
        ];
    }

    private function numberFormat($value, $decimals, $decimalPoint, $thousandSeperator)
    {
        if (is_null($decimals)) {
            $decimals = 2;
        }

        if (is_null($decimalPoint)) {
            $decimalPoint = ',';
        }

        if (is_null($thousandSeperator)) {
            $thousandSeperator = '.';
        }

        return number_format($value, $decimals, $decimalPoint, $thousandSeperator);
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

}
