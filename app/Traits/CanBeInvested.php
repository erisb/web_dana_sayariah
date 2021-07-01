<?php

namespace App\Traits;

trait CanBeInvested
{

    public function getInvestableIdentifier()
    {
        return method_exists($this, 'getKey') ? $this->getKey() : $this->id;
    }

    public function getInvestableDescription()
    {
        if (property_exists($this, 'name'))
            return $this->name;
        if (property_exists($this, 'title'))
            return $this->title;
        if (property_exists($this, 'description'))
            return $this->description;

        return null;
    }

    public function getInvestablePrice()
    {
        if (property_exists($this, 'price'))
            return $this->price;

        return null;
    }
}