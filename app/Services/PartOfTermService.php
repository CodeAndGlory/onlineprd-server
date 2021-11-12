<?php

namespace App\Services;

use App\Models\PartOfTerm;
use Exception;
use Illuminate\Http\Request;

/**
 * Class PartOfTermService
 * @package App\Services
 */
class PartOfTermService extends APIService
{
    /**
     * PartOfTermService constructor.
     * @param  Request  $request
     * @param  PartOfTerm  $partOfTerm
     * @throws Exception
     */
    public function __construct(Request $request, PartOfTerm $partOfTerm)
    {
        $this->setModel($partOfTerm);
        parent::__construct($request);
    }
}
