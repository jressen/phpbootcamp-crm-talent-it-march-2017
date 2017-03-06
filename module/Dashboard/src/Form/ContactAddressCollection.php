<?php

namespace Dashboard\Form;


use Zend\Form\Element\Collection;

class ContactAddressCollection extends Collection
{
    /**
     * @inheritDoc
     */
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setName('contact-address-collection');
        $this->setShouldCreateTemplate(true);
        $this->setAllowAdd(true);
        $this->setTargetElement([
            'type' => ContactAddressFieldset::class,
        ]);
    }

}