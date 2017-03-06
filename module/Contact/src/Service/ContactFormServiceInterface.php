<?php

namespace Contact\Service;


use Contact\Entity\ContactInterface;
use Zend\Stdlib\Parameters;

interface ContactFormServiceInterface
{
    /**
     * Process form data
     *
     * @param Parameters $data
     * @return ContactInterface
     */
    public function processFormData(Parameters $data);
}