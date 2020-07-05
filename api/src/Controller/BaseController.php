<?php

namespace App\Controller;

use App\Service\ComissionService;
use App\Service\Serializer\AppSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

abstract class BaseController extends AbstractController
{
    private array $data = [];
    private int $statusCode;
    private $headers;

    private AppSerializer $serializer;

    public function __construct(AppSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function createResponse(): JsonResponse
    {
        $data = $this->data ?? null;
        $errorMessage = $this->errorMessage ?? null;
        $statusCode = $this->statusCode ?? JsonResponse::HTTP_OK;
        $headers = $this->headers ?? [];

        return new JsonResponse(['result' => $data, 'error' => $errorMessage], $statusCode, $headers);
    }

    public function addData(string $key, $data, $group): self
    {
        $this->data[$key] = $this->serializer->normalize($data, $group);

        return $this;
    }

}
