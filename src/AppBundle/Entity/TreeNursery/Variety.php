<?php

namespace AppBundle\Entity\TreeNursery;

use ApiPlatform\Core\Annotation\{ApiResource, ApiSubresource};
use AppBundle\Entity\TreeNursery\Sort;
use AppBundle\Model\SoftDeleteableEntity;
use AppBundle\Model\{IdentityInterface, IdentityEntity, NameableInterface, NameableEntity};
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Variety (Abelia compacta, Abelia Sarabande, etc...)
 *
 * @ORM\Table(name="tree_nursery_variety")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TreeNursery\VarietyRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deleted_at", timeAware=true)
 *
 * @ApiResource
 */
class Variety implements
    IdentityInterface,
    NameableInterface
{
    use IdentityEntity;
    use NameableEntity;
    use SoftDeleteableEntity;

    /**
     * @var Sort
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TreeNursery\Sort", inversedBy="varieties")
     * @ORM\JoinColumn(name="sort_id", referencedColumnName="id", nullable=false)
     */
    protected $sort;

    /**
     * Uses
     *
     * @var Iterable<Use>
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TreeNursery\TreeProperty\Usage", inversedBy="varieties")
     * @ORM\JoinTable(
     *     name="tree_nursery_varieties_usages",
     *     joinColumns={@ORM\JoinColumn(name="variety_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="usage_id", referencedColumnName="id")}
     * )
     *
     * @ApiSubresource
     */
    protected $usages;

    /**
     * Flower colors
     *
     * @var Collection<FlowerColor>
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TreeNursery\TreeProperty\FlowerColor", inversedBy="varieties")
     * @ORM\JoinTable(
     *     name="tree_nursery_varieties_flower_colors",
     *     joinColumns={@ORM\JoinColumn(name="variety_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="flower_color_id", referencedColumnName="id")}
     * )
     */
    protected $flowerColors;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usages       = new ArrayCollection();
        $this->flowerColors = new ArrayCollection();
    }

    /**
     * Set sort.
     *
     * @param \AppBundle\Entity\TreeNursery\Sort $sort
     *
     * @return Variety
     */
    public function setSort(\AppBundle\Entity\TreeNursery\Sort $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort.
     *
     * @return \AppBundle\Entity\TreeNursery\Sort
     */
    public function getSort(): ?Sort
    {
        return $this->sort;
    }

    /**
     * Add usage.
     *
     * @param \AppBundle\Entity\TreeNursery\TreeProperty\Usage $usage
     *
     * @return Variety
     */
    public function addUsage(\AppBundle\Entity\TreeNursery\TreeProperty\Usage $usage): self
    {
        if (! $this->usages->contains($usage)) {
            $usage->addVariety($this);
            $this->usages->add($usage);
        }

        return $this;
    }

    /**
     * Remove usage.
     *
     * @param \AppBundle\Entity\TreeNursery\TreeProperty\Usage $usage
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUsage(\AppBundle\Entity\TreeNursery\TreeProperty\Usage $usage): bool
    {
        return $this->usages->removeElement($usage);
    }

    /**
     * Get usages.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsages(): \Doctrine\Common\Collections\Collection
    {
        return $this->usages;
    }

    /**
     * Add flowerColor.
     *
     * @param \AppBundle\Entity\TreeNursery\TreeProperty\FlowerColor $flowerColor
     *
     * @return Variety
     */
    public function addFlowerColor(\AppBundle\Entity\TreeNursery\TreeProperty\FlowerColor $flowerColor): self
    {
        if (! $this->flowerColors->contains($flowerColor)) {
            $flowerColor->addVariety($this);
            $this->flowerColors->add($flowerColor);
        }

        return $this;
    }

    /**
     * Remove flowerColor.
     *
     * @param \AppBundle\Entity\TreeNursery\TreeProperty\FlowerColor $flowerColor
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFlowerColor(\AppBundle\Entity\TreeNursery\TreeProperty\FlowerColor $flowerColor): bool
    {
        return $this->flowerColors->removeElement($flowerColor);
    }

    /**
     * Get flowerColors.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFlowerColors(): \Doctrine\Common\Collections\Collection
    {
        return $this->flowerColors;
    }
}
