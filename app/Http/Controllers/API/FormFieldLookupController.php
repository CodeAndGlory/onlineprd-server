<?php

namespace App\Http\Controllers\API;

use App\Services\FormFieldLookupService;

class FormFieldLookupController extends APIController
{
    /**
     * FormFieldLookupController constructor.
     * @param  FormFieldLookupService  $service
     */
    public function __construct(FormFieldLookupService $service)
    {
        parent::__construct($service, 'form_field_lookup');
    }
}
