<?php

namespace App\DataFixtures;

use App\Entity\AppUser;
use App\Utils\FixtureReferences\FixtureReferencesTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppUserFixtures extends Fixture
{
    use FixtureReferencesTrait;

    private array $data = [
        [
            'firstName' => 'Tyrion',
            'lastName' => 'Lannister',
            'type' => AppUser::NATURAL_PERSON_TYPE,
        ],
        [
            'firstName' => 'John',
            'lastName' => 'Snow',
            'type' => AppUser::LEGAL_PERSON_TYPE,
        ],
        [
            'firstName' => 'Aegon',
            'lastName' => 'Targaryen',
            'type' => AppUser::NATURAL_PERSON_TYPE,
        ],
        [
            'firstName' => 'Daenerys',
            'lastName' => 'Targaryen',
            'type' => AppUser::NATURAL_PERSON_TYPE,
        ],
        [
            'firstName' => 'Bran',
            'lastName' => 'Stark',
            'type' => AppUser::NATURAL_PERSON_TYPE,
        ],
    ];

    /**
     * @param ObjectManager $em
     */
    public function load(ObjectManager $em): void
    {
        foreach ($this->data as $key => $data) {
            $entity = (new AppUser())
                ->setFirstName($data['firstName'])
                ->setLastName($data['lastName'])
                ->setType($data['type']);

            $em->persist($entity);
            $this->appUserReferences()->add($key + 1, $entity);
        }

        $em->flush();
    }

    public function getDependencies(): array
    {
        return [

        ];
    }
}