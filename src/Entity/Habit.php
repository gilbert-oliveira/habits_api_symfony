<?php

namespace App\Entity;

use App\Repository\HabitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: HabitRepository::class)]
#[UniqueEntity(fields: ['title'], message: 'There is already a habit with this title')]
class Habit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToMany(targetEntity: Day::class, inversedBy: 'habits', cascade: ['persist'])]
    private Collection $days;

    #[ORM\OneToMany(mappedBy: 'habit', targetEntity: WeekDay::class, cascade: ['persist'], fetch: 'EAGER', orphanRemoval: true)]
    private Collection $weekDays;

    public function __construct()
    {
        $this->days = new ArrayCollection();
        $this->weekDays = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Day>
     */
    public function getDays(): Collection
    {
        return $this->days;
    }

    public function addDay(Day $day): self
    {
        if (!$this->days->contains($day)) {
            $this->days->add($day);
            $day->addHabit($this);
        }

        return $this;
    }

    public function removeDay(Day $day): self
    {
        $this->days->removeElement($day);

        return $this;
    }

    /**
     * @return Collection<int, WeekDay>
     */
    public function getWeekDays(): Collection
    {
        return $this->weekDays;
    }

    public function addWeekDay(WeekDay $weekDay): self
    {
        if (!$this->weekDays->containsKey($weekDay->getWeekday())) {
            $this->weekDays->set($weekDay->getWeekday(), $weekDay);
            $weekDay->setHabit($this);
        }

        return $this;
    }

    public function removeWeekDay(WeekDay $weekDay): self
    {
        if ($this->weekDays->removeElement($weekDay)) {
            // set the owning side to null (unless already changed)
            if ($weekDay->getHabit() === $this) {
                $weekDay->setHabit(null);
            }
        }

        return $this;
    }
}
