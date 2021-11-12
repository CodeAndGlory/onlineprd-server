<?php

namespace App\Services;


use App\Models\FormFieldLookup;
use Exception;
use Illuminate\Http\Request;

/**
 * Class FormFieldLookupService
 * @package App\Services
 */
class FormFieldLookupService extends APIService
{
    /**
     * FormFieldLookupService constructor.
     * @param  Request  $request
     * @param  FormFieldLookup  $formFieldLookup
     * @throws Exception
     */
    public function __construct(Request $request, FormFieldLookup $formFieldLookup)
    {
        $this->setModel($formFieldLookup);
        parent::__construct($request);
    }
}
