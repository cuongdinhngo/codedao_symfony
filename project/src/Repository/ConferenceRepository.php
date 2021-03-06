<?php

namespace App\Repository;

use App\Entity\Conference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Conference|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conference|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conference[]    findAll()
 * @method Conference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conference::class);
    }

    /**
     * @return Conference[] Returns an array of Conference objects
     */
    public function findByCity($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.city = :city')
            ->setParameter('city', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneById($value): ?Conference
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.id = :id')
            ->setParameter('id', $value)
            ->getQuery();
        return $query->getOneOrNullResult();
    }
}
