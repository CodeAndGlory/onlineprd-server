<?php

namespace Tests\Feature\API\v1;

use App\Models\FormFieldLookup;

class FormFieldLookupControllerTest extends ControllerTestCase
{
    protected string $class = FormFieldLookup::class;
    protected string $table = 'form_field_lookups';
    protected string $endpoint = 'form-field-lookups';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new FormFieldLookup();
    }
}
