<?php

namespace App\Repositories;

use App\Contact;

class ContactRepository extends Repository
{
    /**
     * Create new instance of contact repository.
     *
     * @param Contact Contact contact model
     */
    public function __construct(Contact $contact)
    {
        parent::__construct($contact);
        $this->contact = $contact;
    }

    /**
      * Get the contact
      *
      * @return array json object
      */
    public function getContact()
    {
        return $this->model->first();
    }
}
