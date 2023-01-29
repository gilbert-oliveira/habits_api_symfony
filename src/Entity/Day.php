<?php

namespace App\Entity;

use App\Repository\DayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: DayRepository::class)]
#[UniqueEntity(fields: ['date'], message: 'There is already a day with this date')]
class Day implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\ManyToMany(targetEntity: Habit::class, mappedBy: 'days')]
    private Collection $habits;

    public function __construct(\DateTimeImmutable $date = null)
    {
        $this->date = $date ?? (new \DateTimeImmutable())->setTime(0, 0);
        $this->habits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, Habit>
     */
    public function getHabits(): Collection
    {
        return $this->habits;
    }

    public function addHabit(Habit $habit): self
    {
        if (!$this->habits->contains($habit)) {
            $this->habits->add($habit);
            $habit->addDay($this);
        }

        return $this;
    }

    public function removeHabit(Habit $habit): self
    {
        if ($this->habits->removeElement($habit)) {
            $habit->removeDay($this);
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d'),
        ];
    }
}
