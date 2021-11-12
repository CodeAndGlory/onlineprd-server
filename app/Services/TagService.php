<?php

namespace App\Services;

use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;

/**
 * Class TagService
 * @package App\Services
 */
class TagService extends APIService
{
    /**
     * TagService constructor.
     * @param  Request  $request
     * @param  Tag  $tag
     * @throws Exception
     */
    public function __construct(Request $request, Tag $tag)
    {
        $this->setModel($tag);
        parent::__construct($request);
    }
}
