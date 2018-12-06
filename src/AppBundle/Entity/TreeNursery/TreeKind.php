<?php

namespace AppBundle\Entity\TreeNursery;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

use AppBundle\Model\{IdentityInterface, IdentityEntity, NameableInterface, NameableEntity};

/**
 * TreeKind
 *
 * @ORM\Table(name="tree_nursery_tree_kind")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TreeNursery\TreeKindRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deleted_at", timeAware=true)
 */
class TreeKind implements
    IdentityInterface,
    NameableInterface
{
    use IdentityEntity;
    use NameableEntity;
    use SoftDeleteableEntity;

    /**
     * Sorts
     *
     * @var Iterable<Sort>
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TreeNursery\Sort", mappedBy="treeKinds")
     */
    protected $sorts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sorts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add sort.
     *
     * @param \AppBundle\Entity\TreeNursery\Sort $sort
     *
     * @return TreeKind
     */
    public function addSort(\AppBundle\Entity\TreeNursery\Sort $sort): self
    {
        $this->sorts[] = $sort;

        return $this;
    }

    /**
     * Remove sort.
     *
     * @param \AppBundle\Entity\TreeNursery\Sort $sort
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSort(\AppBundle\Entity\TreeNursery\Sort $sort): bool
    {
        return $this->sorts->removeElement($sort);
    }

    /**
     * Get sorts.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSorts(): \Doctrine\Common\Collections\Collection
    {
        return $this->sorts;
    }
}
