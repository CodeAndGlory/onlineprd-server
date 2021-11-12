<?php


namespace App\Services;


use App\Models\EmailTemplate;
use Exception;
use Illuminate\Http\Request;

/**
 * Class EmailTemplate
 * @package App\Services
 */
class EmailTemplateService extends APIService
{
    /**
     * EmailTemplateService constructor.
     * @param  Request  $request
     * @param  EmailTemplate  $email_template
     * @throws Exception
     */
    public function __construct(Request $request, EmailTemplate $email_template)
    {
        $this->setModel($email_template);
        parent::__construct($request);
    }
}
