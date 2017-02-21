<?php

namespace Dashboard\Form;


use Zend\Form\Fieldset;

class ContactEmailFieldset extends Fieldset
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->add([
            'type' => 'hidden',
            'name' => 'contact_email_id',
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'email_address',
            'options' => [
                'label' => 'Email address',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'e.g. firstname.lastname@company.com',
            ],
        ]);

        $this->add([
            'type' => 'radio',
            'name' => 'primary',
            'options' => [
                'label' => 'Primary',
            ],
        ]);
    }
}