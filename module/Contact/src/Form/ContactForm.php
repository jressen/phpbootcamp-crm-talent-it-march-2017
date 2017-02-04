<?php

namespace Contact\Form;


use Zend\Form\Form;

class ContactForm extends Form
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct('contact', $options);

        $this->add([
            'name' => 'contact_id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'first_name',
            'type' => 'text',
            'options' => [
                'Label' => 'First name',
            ],
        ]);

        $this->add([
            'name' => 'last_name',
            'type' => 'text',
            'options' => [
                'Label' => 'Last name',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'options' => [
                'value' => 'Save',
            ],
        ]);
    }
}