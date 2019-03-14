<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sidus\EAVModelBundle\Entity\AbstractValue;
use Sidus\EAVModelBundle\Entity\DataInterface;

/**
 * @ORM\Table(name="invoice_attribue_value", indexes={
 *     @ORM\Index(name="attribute", columns={"attribute_code"}),
 *     @ORM\Index(name="family", columns={"family_code"}),
 *     @ORM\Index(name="string_search", columns={"attribute_code", "string_value"}),
 *     @ORM\Index(name="int_search", columns={"attribute_code", "integer_value"}),
 *     @ORM\Index(name="bool_search", columns={"attribute_code", "bool_value"}),
 *     @ORM\Index(name="position", columns={"position"})
 * })
 * @ORM\Entity(repositoryClass="Sidus\EAVModelBundle\Entity\ValueRepository")
 */
class InvoiceAttributeValue extends AbstractValue
{

    /**
     * @var DataInterface
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Invoice", inversedBy="values", fetch="EAGER")
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $data;
}