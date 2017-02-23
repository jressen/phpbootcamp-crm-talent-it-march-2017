<?php

namespace Dashboard\Form;


use Zend\Form\Fieldset;

class ContactAddressFieldset extends Fieldset
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->add([
            'type' => 'hidden',
            'name' => 'contact_address_id',
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'address_1',
            'options' => [
                'label' => 'Address 1',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'e.g. 123 Sunset Avenue',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'address_2',
            'options' => [
                'label' => 'Address 2',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'e.g. Shipyard Building, Floor 4',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'postcode',
            'options' => [
                'label' => 'Postcode',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'e.g. 12021',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'city',
            'options' => [
                'label' => 'City',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'e.g. Los Angeles',
            ],
        ]);

        $this->add([
            'type' => 'select',
            'name' => 'country_code',
            'options' => [
                'label' => 'Country',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);
    }
}