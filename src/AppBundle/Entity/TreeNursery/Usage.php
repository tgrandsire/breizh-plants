<?php

namespace AppBundle\Entity\TreeNursery;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

use AppBundle\Model\{IdentityInterface, IdentityEntity, NameableInterface, NameableEntity};


/**
 * Use
 *
 * @ORM\Table(name="tree_nursery_usage")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TreeNursery\UsageRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deleted_at", timeAware=true)
 */
class Usage implements
    IdentityInterface,
    NameableInterface
{
    use IdentityEntity;
    use NameableEntity;
    use SoftDeleteableEntity;

    /**
     * Varieties
     *
     * @var Iterable<Variety>
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TreeNursery\Variety", mappedBy="usages")
     */
    protected $varieties;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->varieties = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add variety.
     *
     * @param \AppBundle\Entity\TreeNursery\Variety $variety
     *
     * @return Usage
     */
    public function addVariety(\AppBundle\Entity\TreeNursery\Variety $variety): self
    {
        $this->varieties[] = $variety;

        return $this;
    }

    /**
     * Remove variety.
     *
     * @param \AppBundle\Entity\TreeNursery\Variety $variety
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeVariety(\AppBundle\Entity\TreeNursery\Variety $variety): bool
    {
        return $this->varieties->removeElement($variety);
    }

    /**
     * Get varieties.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVarieties(): \Doctrine\Common\Collections\Collection
    {
        return $this->varieties;
    }
}
