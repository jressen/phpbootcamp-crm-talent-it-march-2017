<?php

namespace Contact\Form;


use Contact\Model\Contact;
use Contact\Model\ContactHydrator;
use Zend\Form\Fieldset;

class ContactFieldset extends Fieldset
{
    public function init()
    {
        $this->setHydrator(new ContactHydrator());
        $this->setObject(new Contact(0, '', ''));

        $this->add([
            'type' => 'hidden',
            'name' => 'contact_id',
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'first_name',
            'options' => [
                'label' => 'First name'
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'last_name',
            'options' => [
                'label' => 'Last name'
            ],
        ]);
    }
}