<?php

namespace Dashboard\Form;


use Zend\Form\Element\Collection;

class ContactEmailCollection extends Collection
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->setName('contact-email-collection');
        $this->setShouldCreateTemplate(true);
        $this->setAllowAdd(true);
        $this->setTargetElement([
            'type' => ContactEmailFieldset::class,
        ]);
    }
}