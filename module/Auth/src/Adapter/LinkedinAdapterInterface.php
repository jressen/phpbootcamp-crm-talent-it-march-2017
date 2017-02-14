<?php

namespace Auth\Adapter;


use Zend\Authentication\Adapter\AdapterInterface;

interface LinkedinAdapterInterface extends AdapterInterface
{
    public function getMember();
}