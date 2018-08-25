<?php

namespace Mdojr\EmailProvider\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mdojr\EmailProvider\Entity\Helper\ArrayCopy;
use Mdojr\EmailProvider\Entity\VirtualDomains;

/**
 * VirtualUsers
 *
 * @ORM\Table(name="virtual_users", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})}, indexes={@ORM\Index(name="domain_id", columns={"domain_id"})})
 * @ORM\Entity
 */
class VirtualUsers implements ArrayCopy
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
     * @ORM\Column(name="password", type="string", length=106, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=120, nullable=false)
     */
    private $email;

    /**
     * @var \Mdojr\EmailProvider\Entity\VirtualDomains
     *
     * @ORM\ManyToOne(targetEntity="Mdojr\EmailProvider\Entity\VirtualDomains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="domain_id", referencedColumnName="id")
     * })
     */
    private $domain;

    public function __construct(string $email, string $password, VirtualDomains $domain)
    {
        $this->email = $email;
        $this->password = $password;
        $this->domain = $domain;
    }

    public function getArrayCopy() : array
    {
        $vars = get_object_vars($this);
        unset($vars['password']);
        unset($vars['domain']);
        return $vars;
    }

    public function __get($propertyName)
    {
        return $this->$propertyName;
    }
}
