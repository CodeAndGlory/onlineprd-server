<?php

namespace App\Services;

use App\Models\Eclass;
use Exception;
use Illuminate\Http\Request;

/**
 * Class EclassService
 * @package App\Services
 */
class EclassService extends APIService
{
    /**
     * EclassService constructor.
     * @param  Request  $request
     * @param  Eclass  $eclass
     * @throws Exception
     */
    public function __construct(Request $request, Eclass $eclass)
    {
        $this->setModel($eclass);
        parent::__construct($request);
    }
}
