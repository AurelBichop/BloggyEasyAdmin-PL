<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function add(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //Search with Criteria Doctrine
    public function findAllPublishedOrderedBy(): Collection
    {
        $criteria = (new Criteria)
            ->andWhere(Criteria::expr()->neq('publishedAt',null))
            ->orderBy(['publishedAt'=> Criteria::DESC])
        ;

        return $this->matching($criteria);
    }
    
    public function findAllPublishedOrderedByQuery(): Collection
    {
        $criteria = (new Criteria)
            ->andWhere(Criteria::expr()->neq('publishedAt',null))
            ->orderBy(['publishedAt'=> Criteria::DESC])
        ;

        return $this->matching($criteria);
    }    

    public function findOneByPublishDateAndSlug(int $year,int $month,int $day,string $slug): ?Post
    {
        return $this->createQueryBuilder('p')
         ->andWhere('YEAR(p.publishedAt) = :year')
        ->andWhere('MONTH(p.publishedAt) = :month')
        ->andWhere('DAY(p.publishedAt) = :day')
        ->andWhere('p.slug = :slug')
            ->setParameters([
                'year'=> $year,
                'month'=> $month,
                'day'=> $day,
                'slug'=> $slug,
                ])
            ->getQuery()
            ->getOneOrNullResult()
       ;
    }

//    /**
//     * @return Post[] Returns an array of Post objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
