<?php

namespace Mdojr\EmailProvider\Entity;

use Doctrine\ORM\Mapping as ORM;

use Mdojr\EmailProvider\Entity\Helper\ArrayCopy;
use Mdojr\EmailProvider\Entity\VirtualDomains;

/**
 * VirtualAliases
 *
 * @ORM\Table(name="virtual_aliases", indexes={@ORM\Index(name="domain_id", columns={"domain_id"})})
 * @ORM\Entity
 */
class VirtualAliases implements ArrayCopy
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
     * @ORM\Column(name="source", type="string", length=100, nullable=false)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=100, nullable=false)
     */
    private $destination;

    /**
     * @var \Mdojr\EmailProvider\Entity\VirtualDomains
     *
     * @ORM\ManyToOne(targetEntity="Mdojr\EmailProvider\Entity\VirtualDomains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="domain_id", referencedColumnName="id")
     * })
     */
    private $domain;

    public function __construct(string $source, string $destination, VirtualDomains $domain)
    {
        $this->source = $source;
        $this->destination = $destination;
        $this->domain = $domain;
    }

    public function getArrayCopy()
    {
        $vars = get_object_vars($this);
        unset($vars['domain']);
        return $vars;
    }
}
