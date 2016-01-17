<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16.01.16
 * Time: 21:56
 */

namespace Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BookRepository
 */
class BookRepository extends EntityRepository
{
    public function findAllBooks()
    {
        $query = $this->createQueryBuilder("b");
        $query->orderBy('b.publicationAt', 'ASC');
        $q = $query->getQuery();
        $items = $q->getResult();

        return $items;
    }

    public function findAllBooksSort($book)
    {
        $query = $this->createQueryBuilder("b");
        if ($book['publication_at'] || $book['like_count']) {
            if ($book['publication_at'] == 'asc') {
                $query->addOrderBy('b.publicationAt', 'ASC');
            }
            if ($book['publication_at'] == 'desc') {
                $query->addOrderBy('b.publicationAt', 'DESC');
            }
            if ($book['like_count'] == 'asc') {
                $query->addOrderBy('b.likesCount', 'ASC');
            }
            if ($book['like_count'] == 'desc') {
                $query->addOrderBy('b.likesCount', 'DESC');
            }
        }
        else {
            $query->orderBy('b.publicationAt', 'ASC');
        }
        $q = $query->getQuery();
        $items = $q->getResult();

        return $items;
    }

    public function findOne($id)
    {
        $query = $this->createQueryBuilder("b")
            ->where('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $items = $query->getOneOrNullResult();

        return $items;
    }

    public function getSortId($id, $book)
    {
        $query = $this->createQueryBuilder("b")
            ->select('b.id');
        if ($book['publication_at'] || $book['like_count']) {
            if ($book['publication_at'] == 'asc') {
                $query->addOrderBy('b.publicationAt', 'ASC');
            }
            if ($book['publication_at'] == 'desc') {
                $query->addOrderBy('b.publicationAt', 'DESC');
            }
            if ($book['like_count'] == 'asc') {
                $query->addOrderBy('b.likesCount', 'ASC');
            }
            if ($book['like_count'] == 'desc') {
                $query->addOrderBy('b.likesCount', 'DESC');
            }
        }
        else {
            $query->orderBy('b.id', 'ASC');
        }
        $q = $query->getQuery();
        $items = $q->getResult();

        return $items;
    }
}
