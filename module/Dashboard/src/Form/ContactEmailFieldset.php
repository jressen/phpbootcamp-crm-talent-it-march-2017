<?php

namespace Dashboard\Form;


use Contact\Entity\EmailAddress;
use Contact\Entity\EmailAddressHydrator;
use Zend\Form\Fieldset;

class ContactEmailFieldset extends Fieldset
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new EmailAddressHydrator());
        $this->setObject(new EmailAddress());

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
                'value_options' => [
                    0 => 'No',
                    1 => 'Yes',
                ],
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);
    }
}