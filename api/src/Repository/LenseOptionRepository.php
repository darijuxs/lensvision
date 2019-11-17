<?php

namespace App\Repository;

use App\Entity\Database\LenseOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class LenseOptionValueRepository
 *
 * @package App\Repository
 */
class LenseOptionRepository extends ServiceEntityRepository
{
    /**
     * LenseOptionRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LenseOption::class);
    }

    /**
     * @param int $id
     *
     * @return LenseOption
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOne(int $id): ?LenseOption
    {
        $query = $this->createQueryBuilder('l')
            ->where('l.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $results = $query->getOneOrNullResult();

        return $results;
    }

    /**
     * @param array $types
     *
     * @return LenseOption[]
     */
    public function getAllByTypes(array $types): array
    {
        $query = $this->createQueryBuilder('l')
            ->where('l.type IN (:type)')
            ->setParameter('type', $types)
            ->getQuery();

        $results = $query->getResult();

        return $results;
    }
}
