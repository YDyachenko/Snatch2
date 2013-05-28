<?php

namespace Application\Model;

class Account extends AbstractModel
{
    public function balance()
    {
        return round($this->balance, 2) . ' RUB';
    }
}