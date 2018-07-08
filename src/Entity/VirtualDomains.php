<?php

namespace Mdojr\EmailProvider\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mdojr\EmailProvider\Entity\Helper\ArrayCopy;
/**
 * VirtualDomains
 *
 * @ORM\Table(name="virtual_domains", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 * @ORM\Entity
 */
class VirtualDomains implements ArrayCopy
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function __get($propertyName)
    {
        return $this->$propertyName;
    }
}
