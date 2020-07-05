<?php

namespace App\Entity;

use App\Repository\AppUserRepository;
use App\Utils\Enum\UserTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AppUserRepository::class)
 */
class AppUser
{
    public const LEGAL_PERSON_TYPE = UserTypeEnum::LEGAL_PERSON_TYPE;
    public const NATURAL_PERSON_TYPE = UserTypeEnum::NATURAL_PERSON_TYPE;

    /**
     * @Groups({"commission"})
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @AppAssert\Enum(class="App\Utils\Enum\UserTypeEnum")
     *
     * @ORM\Column(type="string", length=14)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function isNaturalPerson(): bool
    {
        return $this->type === self::NATURAL_PERSON_TYPE;
    }

    public function isLegalPerson(): bool
    {
        return $this->type === self::LEGAL_PERSON_TYPE;
    }
}
