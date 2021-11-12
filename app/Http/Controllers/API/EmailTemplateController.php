<?php


namespace App\Http\Controllers\API;


use App\Services\EmailTemplateService;

class EmailTemplateController extends APIController
{
    public function __construct(EmailTemplateService $service)
    {
        parent::__construct($service, 'email_template');
    }
}
