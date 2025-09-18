<?php

namespace App\Repository;

use App\Entity\ConvUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

/**
 * @extends ServiceEntityRepository<ConvUser>
 */
class ConvUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConvUser::class);
    }

    //    /**
    //     * @return ConvUser[] Returns an array of ConvUser objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ConvUser
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findConversationsForUser(User $user): array
    {
        return $this->createQueryBuilder('cu')
            ->join('cu.convs', 'c')
            ->where('cu.users = :user')
            ->setParameter('user', $user)
            ->orderBy('c.date_last_message', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
