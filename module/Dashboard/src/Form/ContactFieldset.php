<?php

namespace Dashboard\Form;


use Zend\Form\Fieldset;

class ContactFieldset extends Fieldset
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->add([
            'type' => 'hidden',
            'name' => 'contact_id',
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'first_name',
            'options' => [
                'label' => 'First name',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'last_name',
            'options' => [
                'label' => 'Last name',
            ],
        ]);
    }
}