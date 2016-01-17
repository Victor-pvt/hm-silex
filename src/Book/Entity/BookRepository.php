<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16.01.16
 * Time: 21:56
 */

namespace Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * BookRepository
 */
class BookRepository extends EntityRepository{
    public function findAllBooks($book)
    {
        $query =  $this->createQueryBuilder("b");

        if($book['publication_at'] || $book['like_count']){
            $s1 = 'b.publication_at' . ' ' . $book['publication_at'];
            $s2 = 'b.like_count' . ' ' . $book['like_count'];
            $query->orderBy($s1);
            $query->addOrderBy($s2);
        }else{
            $query->orderBy('b.publicationAt', 'ASC');
        }
        $q = $query->getQuery();

        $items = $q->getResult();
        return $items;
    }
    public function findOne($id){
        $query =  $this->createQueryBuilder("b")
            ->where('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $items = $query->getOneOrNullResult();
        return $items;
    }

    public function findPrev($id){
        $query =  $this->createQueryBuilder("b")
            ->select('b.id')
            ->where('b.id < :id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->orderBy('b.id', 'DESC')
            ->getQuery();
        $items = $query->getResult();
        return count($items)>0 ? $items[0] : null ;
    }
    public function findNext($id){
        $query =  $this->createQueryBuilder("b")
            ->select('b.id')
            ->where('b.id > :id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->orderBy('b.id', 'ASC')
            ->getQuery();
        $items = $query->getResult();
        return count($items)>0 ? $items[0] : null ;
    }
}
