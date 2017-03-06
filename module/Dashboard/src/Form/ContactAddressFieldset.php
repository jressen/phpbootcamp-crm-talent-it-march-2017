<?php

namespace Dashboard\Form;


use Contact\Entity\Address;
use Contact\Entity\AddressHydrator;
use Zend\Form\Fieldset;

class ContactAddressFieldset extends Fieldset
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new AddressHydrator());
        $this->setObject(new Address());

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
                'placeholder' => 'e.g. Noorderlaan 32414',
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
                'placeholder' => 'e.g. 2000',
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
                'placeholder' => 'e.g. Antwerp',
            ],
        ]);

        $this->add([
            'name' => 'country',
            'type' => CountryFieldset::class,
        ]);
    }
}