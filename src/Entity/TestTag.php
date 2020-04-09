<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Test;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class TestTag
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",name="id")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string",name="name")
     * @Assert\Length(
     *     min=1,
     *     max=1,
     *     allowEmptyString=false
     * )
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Test", mappedBy="tags")
     * @var Collection|Test[]
     */
    private $tests;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Test[]|Collection
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * @param Test[]|Collection $tests
     */
    public function setTests($tests): void
    {
        $this->tests = $tests;
    }

    /**
     * @param \App\Entity\Test $test
     */
    public function addTest(Test $test)
    {
        if($this->tests->contains($test)) {
            return;
        }

        $this->tests->add($test);
        $test->addTag($this);
    }

    /**
     * @param \App\Entity\Test $test
     */
    public function removeTest(Test $test)
    {
        if(!$this->tests->contains($test)) {
            return;
        }

        $this->tests->removeElement($test);
        $test->removeTag($this);
    }

}