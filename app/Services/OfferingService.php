<?php

namespace App\Services;

use App\Models\Offering;
use Exception;
use Illuminate\Http\Request;

/**
 * Class OfferingService
 * @package App\Services
 */
class OfferingService extends APIService
{
    /**
     * OfferingService constructor.
     * @param  Request  $request
     * @param  Offering  $offering
     * @throws Exception
     */
    public function __construct(Request $request, Offering $offering)
    {
        $this->setModel($offering);
        parent::__construct($request);
    }
}
