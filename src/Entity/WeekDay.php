<?php

namespace App\Entity;

use App\Repository\WeekDayRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeekDayRepository::class)]
class WeekDay implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'week_day', type: 'integer')]
    private ?int $weekday = null;

    #[ORM\ManyToOne(inversedBy: 'weekDays')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Habit $habit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeekday(): ?int
    {
        return $this->weekday;
    }

    public function setWeekday(int $weekday): self
    {
        $this->weekday = $weekday;

        return $this;
    }

    public function getHabit(): ?Habit
    {
        return $this->habit;
    }

    public function setHabit(?Habit $habit): self
    {
        $this->habit = $habit;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'weekDay' => $this->weekday,
        ];
    }
}
