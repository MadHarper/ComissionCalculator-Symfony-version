<?php

namespace App\Utils\FixtureReferences;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

abstract class Reference
{
    /**
     * @var AbstractFixture
     */
    protected $fixtures;

    private $keys = [];

    private $tagKeys = [];

    public function __construct(ORMFixtureInterface $fixtures)
    {
        $this->fixtures = $fixtures;
    }

    abstract public function getName();

    public function get($key)
    {
        return $this->fixtures->getReference($this->getName() . $key);
    }

    public function add($key, $object, string $tag = null): void
    {
        if ((null !== $tag) && !array_key_exists($key, $this->tagKeys)) {
            $this->tagKeys[$tag][] = $key;
        }

        if (!array_key_exists($key, $this->keys)) {
            $this->keys[] = $key;
        } else {
            return;
        }

        $this->fixtures->addReference($this->getName() . $key, $object);
    }

    public function getRandom(string $tag = null)
    {
        if (null !== $tag) {
            return $this->get($this->tagKeys[array_rand($this->tagKeys)]);
        }

        return $this->get($this->keys[array_rand($this->keys)]);
    }

    /**
     * @param string|null $tag
     * @return object|null
     * @throws \Exception
     */
    public function getRandomOrNull(string $tag = null)
    {
        return random_int(0, 1) ? $this->getRandom($tag) : null;
    }

    public function keys(): array
    {
        return $this->keys;
    }

    public function tagKeys(string $tag): array
    {
        return $this->tagKeys[$tag];
    }
}