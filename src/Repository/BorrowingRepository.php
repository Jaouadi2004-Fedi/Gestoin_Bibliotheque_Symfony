<?php

namespace App\Repository;

use App\Entity\Borrowing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Borrowing>
 */
class BorrowingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borrowing::class);
    }

    /**
     * Return array of most popular books (title and count) ordered by count desc.
     * Uses a raw SQL query via the connection.
     *
     * @return array<int, array<string,mixed>>
     */
    public function findMostPopularBooks(): array
    {
        $sql = "SELECT b2.title, COUNT(*) AS howMany\n"
            . "FROM borrowing b1\n"
            . "INNER JOIN book b2 ON b2.id = b1.book_id\n"
            . "GROUP BY b2.title\n"
            . "ORDER BY howMany DESC";

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery()->fetchAllAssociative();

        return $result;
    }

//    /**
//     * @return Borrowing[] Returns an array of Borrowing objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Borrowing
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findMostPopularBooksQb()
{
return $this->createQueryBuilder('b')
->addSelect('bk.title, COUNT(b) AS howMany')
->join('b.book', 'bk')
->groupBy('bk.title')
->orderBy('howMany','DESC')
->getQuery()
->getResult();
}
public function findMostPopularBooksDql()
{
$query = $this->_em->createQuery('SELECT bk.title, COUNT(b) AS howMany
FROM App\Entity\Borrowing b
JOIN b.book bk
GROUP BY bk.title
 ORDER BY howMany DESC');
$borrowings = $query->getResult();
return $borrowings;
}

}
