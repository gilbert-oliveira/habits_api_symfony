<?php

namespace App\Features;

use App\Entity\SummaryDTO;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class SummaryFeature
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getSummary(): array
    {
        $sql = <<<SQL
        SELECT d.id,d.date,
            (
                SELECT
                    count(*)
                FROM habit_day hd
                WHERE hd.day_id = d.id
            ) AS completed,
            (
                SELECT
                    count(*)
                FROM week_day AS wd
                    JOIN habit AS h
                    ON wd.habit_id = h.id
                WHERE wd.week_day = DATE_FORMAT(d.date, '%w')
            ) AS amount
        FROM day AS d
        SQL;

        $rsm = new ResultSetMappingBuilder($this->entityManager);
        $rsm->addRootEntityFromClassMetadata(SummaryDTO::class, 's');

        $createNativeQuery = $this->entityManager->createNativeQuery($sql, $rsm);

        return $createNativeQuery->getResult();
    }
}