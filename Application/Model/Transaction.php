<?php

namespace Application\Model;

class Transaction extends AbstractModel
{
    public function sum()
    {
        return round($this->sum, 2) . ' RUB';
    }
}