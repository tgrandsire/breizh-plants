<?php

namespace AppBundle\Entity\TreeNursery;

use ApiPlatform\Core\Annotation\{ApiResource, ApiSubresource};
use AppBundle\Model\SoftDeleteableEntity;
use AppBundle\Model\{IdentityInterface, IdentityEntity};
use AppBundle\Model\{NameableInterface, NameableEntity};
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Sort (Species as Abelia, Rosmarinus)
 *
 * @ORM\Table(name="tree_nursery_sort")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TreeNursery\SortRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deleted_at", timeAware=true)
 *
 * @ApiResource
 */
class Sort implements
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TreeNursery\Variety", mappedBy="sort")
     *
     * @ApiSubresource()
     */
    protected $varieties;

    /**
     * Tree Kinds
     *
     * @var Iterable<TreeKind>
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TreeNursery\TreeProperty\TreeKind", inversedBy="sorts")
     * @ORM\JoinTable(
     *     name="tree_nursery_sorts_tree_kinds",
     *     joinColumns={@ORM\JoinColumn(name="sort_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tree_kind_id", referencedColumnName="id")}
     * )
     *
     * @ApiSubresource()
     */
    protected $treeKinds;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->varieties = new \Doctrine\Common\Collections\ArrayCollection();
        $this->treeKinds = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add variety.
     *
     * @param \AppBundle\Entity\TreeNursery\Variety $variety
     *
     * @return Sort
     */
    public function addVariety(\AppBundle\Entity\TreeNursery\Variety $variety): self
    {
        if (! $this->varieties->contains($variety)) {
            $variety->setSort($this);
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

    /**
     * Add treeKind.
     *
     * @param \AppBundle\Entity\TreeNursery\TreeProperty\TreeKind $treeKind
     *
     * @return Sort
     */
    public function addTreeKind(\AppBundle\Entity\TreeNursery\TreeProperty\TreeKind $treeKind): self
    {
        if (! $this->treeKinds->contains($treeKind)) {
            $treeKind->addSort($this);
            $this->treeKinds->add($treeKind);
        }

        return $this;
    }

    /**
     * Remove treeKind.
     *
     * @param \AppBundle\Entity\TreeNursery\TreeProperty\TreeKind $treeKind
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTreeKind(\AppBundle\Entity\TreeNursery\TreeProperty\TreeKind $treeKind): bool
    {
        return $this->treeKinds->removeElement($treeKind);
    }

    /**
     * Get treeKinds.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTreeKinds(): \Doctrine\Common\Collections\Collection
    {
        return $this->treeKinds;
    }
}
