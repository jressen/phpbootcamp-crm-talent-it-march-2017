<?php

namespace Dashboard\Form;

use Zend\Form\Form;

class ContactForm extends Form
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->add([
            'name' => 'contact-fieldset',
            'type' => ContactFieldset::class,
        ]);

        $this->add([
            'name' => 'contact-email-fieldset',
            'type' => ContactEmailFieldset::class,
        ]);

        $this->add([
            'name' => 'contact-address-fieldset',
            'type' => ContactAddressFieldset::class,
        ]);

        $this->add([
            'name' => 'csrf',
            'type' => 'csrf',
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save contact',
            ],
        ]);
    }
}