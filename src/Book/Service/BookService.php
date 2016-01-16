<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16.01.16
 * Time: 22:50
 */

namespace Service;
use Entity\Book;
use Doctrine\ORM\EntityManager;


class BookService {
    private $em;
    private $entity;

    public function __construct(EntityManager $em, Book $entity)
    {
        $this->em = $em;
        $this->entity = $entity;
    }
    public function read()
    {
        $repo = $this->em->getRepository("Entity\Book");
        $out = $repo->findAll();

        return $out ;
    }
    public function readOne($id = null)
    {
        $repo = $this->em->getRepository("Entity\Book");
        $out = $repo->findOne($id);

        return $out ;
    }
    public function save($data)
    {
        $repo = $this->em->getRepository("Entity\Book");
        $this->entity->setAuthorName($data['authorName']);
        $this->entity->setMessage($data['message']);

        try {
            $this->em->persist($this->entity);
            $this->em->flush();
        } catch(\Exception $error) {
            return [
                'success' => false,
            ];
        }
    }
}

