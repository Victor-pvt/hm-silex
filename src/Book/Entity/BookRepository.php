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
    public function findAll()
    {
        $query =  $this->createQueryBuilder("b")
            ->orderBy('b.publicationAt', 'ASC')
            ->getQuery();
        $items = $query->getResult();
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
}
