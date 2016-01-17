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
use Silex\Application;


class BookService {
    private $em;
    private $app;
    private $entity;

    public function __construct(EntityManager $em, Book $entity, Application $app)
    {
        $this->em = $em;
        $this->app = $app;
        $this->entity = $entity;
    }
    public function read($request)
    {
        $book = [
            'publication_at' => $request->query->get('publication_at', null),
            'like_count' => $request->query->get('like_count', null),
        ];

        $repo = $this->em->getRepository("Entity\Book");
        $out = $repo->findAllBooks($book);

        return $out ;
    }
    public function readOne($id = null)
    {
        $repo = $this->em->getRepository("Entity\Book");
        $out = $repo->findOne($id);

        return $out ;
    }
    public function readOnePrev($id = null)
    {
        $repo = $this->em->getRepository("Entity\Book");
        $out = $repo->findPrev($id);

        return $out ;
    }
    public function readOneNext($id = null)
    {
        $repo = $this->em->getRepository("Entity\Book");
        $out = $repo->findNext($id);

        return $out ;
    }

    public function save($data)
    {
        $this->entity->setAuthorName($data['authorName']);
        $this->entity->setMessage($data['message']);
        $this->entity->setAuthorIp($data['authorIp']);

        try {
            $this->em->persist($this->entity);
            $this->em->flush();
        } catch(\Exception $error) {
            return [
                'success' => false,
            ];
        }
    }
    public function likeIpSave($id, $data)
    {
        $repo = $this->em->getRepository("Entity\Book");
        $record = $repo->findOne($id);

        $isLikeIp = $record->addLikeIp($data['likeIp']);
        if($isLikeIp){
            $record->setLikesCount($record->getLikesCount() + 1);
            try {
                $this->em->persist($record);
                $this->em->flush();
            } catch(\Exception $error) {
                return false;
            }
        }else{
            return false;
        }
    }
    public function createForm($request){
        $book = [
            'authorName' => $request->request->get('authorName', null),
            'message' => $request->request->get('message', null),

        ];
        $form = $this->app['form.factory']->createBuilder('form', $book )
            ->add('authorName')
            ->add('message' , 'textarea', ['label' => 'Сообщение', 'required' => true])
            ->getForm();

        return $form ;
    }
}

