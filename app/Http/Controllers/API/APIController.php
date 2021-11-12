<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Model;
use App\Services\APIService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

abstract class APIController extends Controller
{
    /**
     * @var APIService
     */
    protected APIService $service;
    /**
     * @var string
     */
    protected string $singular;
    /**
     * @var string
     */
    protected string $plural;

    /**
     * APIController constructor.
     * @param  APIService  $service
     * @param  string  $singular
     * @param  string|bool  $plural
     */
    public function __construct(APIService $service, $singular, $plural = false)
    {
        $this->service = $service;
        $this->setSingular($singular);
        $this->setPlural($plural);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->formatResponse($this->plural, $this->service->index(), $this->service->getCount());
    }

    public function formatResponse(string $dataName, $data, int $count = 1)
    {
        return response()->json([
            'error' => $this->service->getError(),
            $dataName => $data,
            'count' => $count,
        ], $this->service->getStatus());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return $this->formatResponse($this->singular, $this->service->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  Model  $model
     * @return JsonResponse
     */
    public function show(Model $model): JsonResponse
    {
        return $this->formatResponse($this->singular, $this->service->show($model));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Model  $model
     * @return JsonResponse
     */
    public function update(Request $request, Model $model): JsonResponse
    {
        return $this->formatResponse($this->singular, $this->service->update($request, $model));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Model  $model
     * @return Response
     */
    public function destroy(Model $model): Response
    {
        $this->service->delete($model);

        return response('', 204);
    }

    /**
     * @param  string  $singular
     */
    protected function setSingular($singular): void
    {
        $this->singular = $singular;
    }

    /**
     * @param  string|boolean  $plural
     */
    protected function setPlural($plural): void
    {
        if (false === $plural) {
            $this->plural = Str::plural($this->singular);
        } else {
            $this->plural = $plural;
        }
    }
}
