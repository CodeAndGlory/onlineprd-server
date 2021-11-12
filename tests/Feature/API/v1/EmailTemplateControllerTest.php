<?php

namespace Tests\Feature\API\v1;

use App\Models\EmailTemplate;

class EmailTemplateControllerTest extends ControllerTestCase
{
    protected string $class = EmailTemplate::class;
    protected string $table = 'email_templates';
    protected string $endpoint = 'email-templates';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new EmailTemplate();
    }
}
