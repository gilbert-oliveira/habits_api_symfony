<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class SummaryDTO implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column]
    private readonly int $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private readonly \DateTimeImmutable $date;

    #[ORM\Column(type: 'integer')]
    private readonly int $completed;

    #[ORM\Column(type: 'integer')]
    private readonly int $amount;

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function setCompleted(int $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'completed' => $this->completed,
            'amount' => $this->amount,
        ];
    }
}