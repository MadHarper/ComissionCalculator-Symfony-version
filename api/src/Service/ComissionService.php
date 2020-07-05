<?php

namespace App\Service;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Service\Calculator\FeeCalculatorInterface;
use App\Service\Serializer\AppSerializer;

class ComissionService
{
    private TransactionRepository $repository;
    private FeeCalculatorInterface $calculator;
    /**
     * @var AppSerializer
     */
    private AppSerializer $serializer;

    public function __construct(TransactionRepository $repository, FeeCalculatorInterface $calculator, AppSerializer $serializer)
    {
        $this->repository = $repository;
        $this->calculator = $calculator;
        $this->serializer = $serializer;
    }

    /**
     * @return Transaction[]
     */
    public function calculateFee(): array
    {
        $transactions = $this->repository->findAll();
        $this->calculator->calculate(...$transactions);

        return $transactions;
    }
}