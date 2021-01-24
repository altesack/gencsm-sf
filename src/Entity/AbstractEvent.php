<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

class AbstractEvent
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id", nullable= true)
     */
    protected $place = null;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255, nullable=true)
     */
    protected $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    protected $description;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set place.
     *
     * @param Place|null $place
     *
     * @return AbstractEvent
     */
    public function setPlace(Place $place = null): AbstractEvent
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place.
     *
     * @return Place|null
     */
    public function getPlace(): ?Place
    {
        return $this->place;
    }

    /**
     * Set date.
     *
     * @param string|null $date
     *
     * @return AbstractEvent
     */
    public function setDate($date = null): AbstractEvent
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Set title.
     *
     * @param string|null $title
     *
     * @return AbstractEvent
     */
    public function setTitle(string $title = null): AbstractEvent
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return AbstractEvent
     */
    public function setDescription(string $description = null): AbstractEvent
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
