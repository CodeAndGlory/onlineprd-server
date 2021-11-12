<?php

namespace App\Http\Controllers\API;

use App\Services\EclassService;

class EclassController extends APIController
{
    protected string $singular = 'eclass';
    protected string $plural = 'eclasses';

    public function __construct(EclassService $service)
    {
        parent::__construct($service, $this->singular, $this->plural);
    }
}
