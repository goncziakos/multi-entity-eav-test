<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sidus\EAVModelBundle\Entity\AbstractData;
use Sidus\EAVModelBundle\Entity\DataInterface;
use Sidus\EAVModelBundle\Entity\ValueInterface;

/**
 * @ORM\Table(name="orders", indexes={
 *     @ORM\Index(name="family", columns={"family_code"}),
 *     @ORM\Index(name="updated_at", columns={"updated_at"}),
 *     @ORM\Index(name="created_at", columns={"created_at"})
 * })
 * @ORM\Entity(repositoryClass="Sidus\EAVModelBundle\Entity\DataRepository") *
 */
class Order extends AbstractData
{
    /**
     * @var ValueInterface[]|Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrderAttributeValue", mappedBy="data",
     *                                                    cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $values;

    /**
     * @var DataInterface
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Order", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $parent;
}