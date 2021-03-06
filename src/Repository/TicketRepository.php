<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }


    public function countAllTicketOpen()
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.state = 1');
        $qb ->select($qb->expr()->count('e'));
        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    // for user
    public function countTicketOpenUser($user)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.state = 1 and e.user = :user')
            ->setParameter('user', $user);
        $qb ->select($qb->expr()->count('e'));
        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    // for user
    public function countTicketCloseUser($user)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.state = 0 and e.user = :user')
            ->setParameter('user', $user);
        $qb ->select($qb->expr()->count('e'));
        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    // for admin
    public function findAllTicketOpen()
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.state = 1');
        $query = $qb->getQuery();
        return $query->execute();
    }

    // for user
    public function findTicketOpenUser($user)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.state = 1 and p.user = :user')
            ->setParameter('user', $user);
        $query = $qb->getQuery();
        return $query->execute();
    }

    // for user
    public function findTicketCloseUser($user)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.state = 0 and p.user = :user')
            ->setParameter('user', $user);
        $query = $qb->getQuery();
        return $query->execute();
    }


    // /**
    //  * @return Ticket[] Returns an array of Ticket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ticket
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
