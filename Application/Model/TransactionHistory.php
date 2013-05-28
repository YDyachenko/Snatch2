<?php

namespace Application\Model;

class TransactionHistory extends AbstractModel
{
    public function sum()
    {
        return round($this->sum, 2) . ' RUB';
    }
}