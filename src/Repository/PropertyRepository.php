<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Entity\User;
use App\Form\PropertyType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Join as Join;
use phpDocumentor\Reflection\Types\Object_;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search) : Query
    {
        $query = $this->findVisibleQuery();

        if ($search->getMaxPrice()){
            $query = $query
                ->andWhere('p.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }

        if ($search->getKeyword()){
            $query = $query
                ->andWhere('p.title LIKE :keyword')
                ->setParameter('keyword', '%' . $search->getKeyword() . '%');
        }

        if($search->getCategory()){
            $query = $query
                ->andWhere(':category = p.category')
                ->setParameter('category', $search->getCategory());
        }
        if($search->getSubcategory())
        {
            $query = $query
                ->andWhere(':subcategory = p.subcategory')
                ->setParameter('subcategory', $search->getSubcategory());
        }

        return $query
            ->orderBy('p.created_at', 'DESC')
            ->getQuery();
    }

    /**
     * @param $search
     * @return Property[]
     */
    public function findAllByUser($search) : array
    {
        $query = $this->findVisibleQuery();

        if ($search->getUsername()){
            $query = $query
                ->leftJoin('p.username', 'u')
                ->andWhere('u.id = :user')
                ->setParameter('user', $search->getId())
                ->orderBy('p.created_at', 'DESC');
        }

        //dd($query->getQuery());
        return $query->getQuery()->getResult();
    }

    /**
     * @return Property[]
     */
    public function findLatest() : array
    {
        return $this->findVisibleQuery()
            ->setMaxResults('4')
            ->orderBy('p.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    private function findVisibleQuery() : QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sold = false');
    }
}
