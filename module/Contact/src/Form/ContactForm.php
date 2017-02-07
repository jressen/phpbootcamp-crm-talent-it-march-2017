<?php

namespace Contact\Form;


use Zend\Form\Form;

class ContactForm extends Form
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct('contact', $options);

        $this->add([
            'name' => 'contact-fieldset',
            'type' => ContactFieldset::class,
            'options' => [
                'use_as_base_fieldset' => true,
            ],
        ]);

        $this->add([
            'name' => 'csrf',
            'type' => 'csrf',
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
            ],
        ]);
    }
}