<?php

namespace App\Repository;

use App\Document\Actualities;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;


class ActualitiesRepository extends DocumentRepository
{
    /**
     * Récupérer toutes les actualités, triées par date de création (DESC)
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
