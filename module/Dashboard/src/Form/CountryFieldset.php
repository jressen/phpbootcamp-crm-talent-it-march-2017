<?php

namespace Dashboard\Form;


use Contact\Entity\Country;
use Contact\Entity\CountryHydrator;
use Zend\Form\Fieldset;

class CountryFieldset extends Fieldset
{

    /**
     * CountryFieldset constructor.
     */
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new CountryHydrator());
        $this->setObject(new Country());

        $this->add([
            'type' => 'select',
            'name' => 'iso',
            'options' => [
                'label' => 'Country',
                'value_options' => [
                    'BE' => 'Belgium',
                    'LU' => 'Luxembourg',
                    'NL' => 'Netherlands',
                ],
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);
    }
}