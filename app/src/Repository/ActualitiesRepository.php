<?php

namespace App\Repository;

use App\Document\Actualities;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;


class ActualitiesRepository extends DocumentRepository
{
    /**
     * Get all the activities by creation date
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder()
            ->sort('createdAt', 'DESC')
            ->getQuery()
            ->execute()
            ->toArray();
    }

  
}
