<?php

namespace App\DataFixtures;

use App\Entity\Money;
use App\Entity\Transaction;
use App\Service\Converter\CurrencyConverterInterface;
use App\Utils\FixtureReferences\FixtureReferencesTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TransactionFixtures extends Fixture
{
    use FixtureReferencesTrait;

//2014-12-31,4,natural,cash_out,1200.00,EUR
//2015-01-01,4,natural,cash_out,1000.00,EUR
//2016-01-05,4,natural,cash_out,1000.00,EUR
//2016-01-05,1,natural,cash_in,200.00,EUR
//2016-01-06,2,legal,cash_out,300.00,EUR
//2016-01-06,1,natural,cash_out,30000,JPY
//2016-01-07,1,natural,cash_out,1000.00,EUR
//2016-01-07,1,natural,cash_out,100.00,USD
//2016-01-10,1,natural,cash_out,100.00,EUR
//2016-01-10,2,legal,cash_in,1000000.00,EUR
//2016-01-10,3,natural,cash_out,1000.00,EUR
//2016-02-15,1,natural,cash_out,300.00,EUR

//2016-02-19,5,natural,cash_out,3000000,JPY

    private array $data = [
        [
            'date' => '2014-12-31 12:40:00',
            'appUser' => 4,
            'operationType' => Transaction::CASH_OUT_OPERATION_TYPE,
            'amount' => 1200.00,
            'currency' => Money::EUR
        ],
        [
            'date' => '2015-01-01 16:10:00',
            'appUser' => 4,
            'operationType' => Transaction::CASH_OUT_OPERATION_TYPE,
            'amount' => 1000.00,
            'currency' => Money::EUR
        ],
        [
            'date' => '2016-01-05 16:10:00',
            'appUser' => 4,
            'operationType' => Transaction::CASH_OUT_OPERATION_TYPE,
            'amount' => 1000.00,
            'currency' => Money::EUR
        ],
        [
            'date' => '2016-01-05 12:10:00',
            'appUser' => 1,
            'operationType' => Transaction::CASH_IN_OPERATION_TYPE,
            'amount' => 200.00,
            'currency' => Money::EUR
        ],
        [
            'date' => '2016-01-06 16:10:00',
            'appUser' => 2,
            'operationType' => Transaction::CASH_OUT_OPERATION_TYPE,
            'amount' => 300.00,
            'currency' => Money::EUR
        ],
        [
            'date' => '2016-01-06 16:10:00',
            'appUser' => 1,
            'operationType' => Transaction::CASH_OUT_OPERATION_TYPE,
            'amount' => 30000,
            'currency' => Money::JPY
        ],
        [
            'date' => '2016-01-07 12:10:00',
            'appUser' => 1,
            'operationType' => Transaction::CASH_OUT_OPERATION_TYPE,
            'amount' => 1000.00,
            'currency' => Money::EUR
        ],
        [
            'date' => '2016-01-07 16:10:00',
            'appUser' => 1,
            'operationType' => Transaction::CASH_OUT_OPERATION_TYPE,
            'amount' => 100.00,
            'currency' => Money::USD
        ],
        [
            'date' => '2016-01-10 12:10:00',
            'appUser' => 1,
            'operationType' => Transaction::CASH_OUT_OPERATION_TYPE,
            'amount' => 100.00,
            'currency' => Money::EUR
        ],
        [
            'date' => '2016-01-10 16:10:00',
            'appUser' => 2,
            'operationType' => Transaction::CASH_IN_OPERATION_TYPE,
            'amount' => 1000000.00,
            'currency' => Money::EUR
        ],
        [
            'date' => '2016-01-10 12:10:00',
            'appUser' => 3,
            'operationType' => Transaction::CASH_OUT_OPERATION_TYPE,
            'amount' => 1000.00,
            'currency' => Money::EUR
        ],
        [
            'date' => '2016-02-15 16:10:00',
            'appUser' => 1,
            'operationType' => Transaction::CASH_OUT_OPERATION_TYPE,
            'amount' => 300.00,
            'currency' => Money::EUR
        ],
        [
            'date' => '2016-02-19 12:10:00',
            'appUser' => 5,
            'operationType' => Transaction::CASH_OUT_OPERATION_TYPE,
            'amount' => 3000000,
            'currency' => Money::JPY
        ],
    ];

    private array $rates = [
        Money::EUR => 1,
        Money::USD => 1.1497,
        Money::JPY => 129.53,
    ];


    private CurrencyConverterInterface $converter;

    public function __construct(CurrencyConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @param ObjectManager $em
     */
    public function load(ObjectManager $em): void
    {
        foreach ($this->rates as $currency => $rate) {
            $this->converter->setRate($currency, $rate);
        }

        foreach ($this->data as $key => $data) {
            $user = $this->appUserReferences()->get($data['appUser']);
            $day = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['date']);
            $money = new Money($data['amount'], $data['currency']);
            $euro = $this->converter->convert($money, Money::EUR);

            $entity = (new Transaction())
                ->setAppUser($user)
                ->setDate($day)
                ->setMoney($money)
                ->setEuro($euro)
                ->setOperationType($data['operationType']);

            $em->persist($entity);
            $this->transactionReferences()->add($key + 1, $entity);
        }

        $em->flush();
    }

    public function getDependencies(): array
    {
        return [
            AppUserFixtures::class,
        ];
    }
}