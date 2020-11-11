<?php

class InvoiceEntity
{
    protected $id;
    protected $status;
    protected $productList;
    protected $amount;

    public function getId()
    {
        return $this->id;
    }

}