<?php

namespace App\Interfaces;

interface Investable
{
    public function getInvestableIdentifier();

    public function getInvestableDescription();

    public function getInvestablePrice();
}