<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FamilyEvent.
 *
 * @ORM\Table(name="family_events")
 * @ORM\Entity(repositoryClass="App\Repository\FamilyEventRepository")
 */
class FamilyEvent extends AbstractEvent
{
    /**
     * Family.
     *
     * @ORM\ManyToOne(targetEntity="Family", inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn(name="family_id", referencedColumnName="id", nullable=true)
     */
    private $family;

    /**
     * Get many persons could be born in the one family.
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Set many persons could be born in the one family.
     *
     * @param Family $family
     *
     * @return self
     */
    public function setFamily(Family $family): FamilyEvent
    {
        $this->family = $family;
        $family->addEvent($this);

        return $this;
    }
}
