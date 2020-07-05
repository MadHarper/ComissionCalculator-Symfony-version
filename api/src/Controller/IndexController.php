<?php

namespace App\Controller;

use App\Service\ComissionService;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends BaseController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(ComissionService $service)
    {
        $data = $service->calculateFee();
        $this->addData('transactions', $data, 'commission');

        return $this->createResponse();
    }
}
