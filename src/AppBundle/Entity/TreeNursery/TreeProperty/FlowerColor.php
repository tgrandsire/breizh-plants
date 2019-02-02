<?php

namespace AppBundle\Entity\TreeNursery\TreeProperty;

use AppBundle\Model\SoftDeleteableEntity;
use AppBundle\Model\{IdentityInterface, IdentityEntity};
use AppBundle\Model\{NameableInterface, NameableEntity};
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * FlowerColor
 *
 * @ORM\Table(name="tree_nursery_tree_property_flower_color")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TreeNursery\TreeProperty\FlowerColorRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deleted_at", timeAware=true)
 */
class FlowerColor implements
    IdentityInterface,
    NameableInterface
{
    use IdentityEntity;
    use NameableEntity;
    use SoftDeleteableEntity;

    /**
     * Varieties
     *
     * @var Collection<Variety>
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TreeNursery\Variety", mappedBy="flowerColors")
     */
    protected $varieties;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->varieties = new ArrayCollection();
    }

    /**
     * Add variety.
     *
     * @param \AppBundle\Entity\TreeNursery\Variety $variety
     *
     * @return FlowerColor
     */
    public function addVariety(\AppBundle\Entity\TreeNursery\Variety $variety): self
    {
        if (! $this->varieties->contains($variety)) {
            $variety->addFlowerColor($this);
            $this->varieties->add($variety);
        }

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
