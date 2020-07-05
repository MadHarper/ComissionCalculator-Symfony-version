<?php

namespace App\Entity;

use App\Validator\Constraints as AppAssert;
use App\Repository\TransactionRepository;
use App\Utils\Enum\OperationTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    public const CASH_IN_OPERATION_TYPE = OperationTypeEnum::CASH_IN_OPERATION_TYPE;
    public const CASH_OUT_OPERATION_TYPE = OperationTypeEnum::CASH_OUT_OPERATION_TYPE;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="immutable_datetime")
     */
    private $date;

    /**
     * @var AppUser
     *
     * @Groups({"commission"})
     *
     * @ORM\ManyToOne(targetEntity=AppUser::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $appUser;

    /**
     * @var string|null
     *
     * @Groups({"commission"})
     *
     * @AppAssert\Enum(class="App\Utils\Enum\OperationTypeEnum")
     * @ORM\Column(type="string", length=14)
     */
    private $operationType;

    /**
     * @var Money
     *
     * @Groups({"commission"})
     *
     * @ORM\Embedded(class="Money")
     */
    private $money;

    /**
     * @var Money
     *
     * @ORM\Embedded(class="Money")
     */
    private $euro;

    /**
     * @Groups({"commission"})
     *
     * @var Money
     */
    private $fee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAppUser(): ?AppUser
    {
        return $this->appUser;
    }

    public function setAppUser(?AppUser $appUser): self
    {
        $this->appUser = $appUser;

        return $this;
    }

    public function getMoney(): Money
    {
        return $this->money;
    }

    public function setMoney(Money $money): self
    {
        $this->money = $money;

        return $this;
    }

    public function getEuro(): Money
    {
        return $this->euro;
    }

    public function setEuro(Money $euro): self
    {
        $this->euro = $euro;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->appUser->getId();
    }

    public function getStartOfWeek(): DateTimeImmutable
    {
        return $this->date->modify('Monday this week');
    }

    public function getStartOfWeekTimestamp(): int
    {
        return $this->getStartOfWeek()->getTimestamp();
    }

    public function setOperationType(string $operationType): self
    {
        $this->operationType = $operationType;

        return $this;
    }

    public function getOperationType(): string
    {
        return $this->operationType;
    }

    public function hasCashOutType(): bool
    {
        return $this->operationType === self::CASH_OUT_OPERATION_TYPE;
    }

    public function hasCashInType(): bool
    {
        return $this->operationType === self::CASH_IN_OPERATION_TYPE;
    }

    public function isNaturalPerson(): bool
    {
        return $this->appUser->isNaturalPerson();
    }

    public function isLegalPerson(): bool
    {
        return $this->appUser->isLegalPerson();
    }

    public function getUserType(): string
    {
        return $this->appUser->getType();
    }

    public function setFee(Money $fee): void
    {
        $this->fee = $fee;
    }

    public function getFee(): Money
    {
        return $this->fee;
    }

    /**
     * @Groups({"commission"})
     */
    public function getHumanDate()
    {
        return $this->date->format('Y-m-d');
    }
}
