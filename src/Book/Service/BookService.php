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


class BookService
{
    private $em;
    private $app;
    private $entity;

    public function __construct(EntityManager $em, Book $entity, Application $app)
    {
        $this->em = $em;
        $this->app = $app;
        $this->entity = $entity;
    }
    public function readSort($book)
    {
        $repo = $this->em->getRepository("Entity\Book");
        $out = $repo->findAllBooksSort($book);

        return $out;
    }

    public function readOne($id = NULL)
    {
        $repo = $this->em->getRepository("Entity\Book");
        $out = $repo->findOne($id);

        return $out;
    }

    public function readSortId($id, $getBook)
    {
        $repo = $this->em->getRepository("Entity\Book");
        $records = $repo->getSortId($id, $getBook);
        $output = [];
        foreach ($records as $key => $record) {
            $output[$record['id']] = $record['id'];
        }
        $prev = $id;
        $next = $id;

        reset($output);
        while (list($key, $val) = each($output)) {
            if ($id == $val) {
                $next = current($output);
                if ($next === FALSE) {
                    $next = $val;
                }
                break;
            }
            $prev = $val;
        }

        $out = [
            'prev' => $prev,
            'next' => $next,
        ];

        return $out;
    }

    public function save($data)
    {
        $this->entity->setAuthorName($data['authorName']);
        $this->entity->setMessage($data['message']);
        $this->entity->setAuthorIp($data['authorIp']);

        try {
            $this->em->persist($this->entity);
            $this->em->flush();
        } catch (\Exception $error) {
            return [
                'success' => FALSE,
            ];
        }
    }

    public function likeIpSave($id, $data)
    {
        $repo = $this->em->getRepository("Entity\Book");
        $record = $repo->findOne($id);

        $isLikeIp = $record->addLikeIp($data['likeIp']);
        if ($isLikeIp) {
            $record->setLikesCount($record->getLikesCount() + 1);
            try {
                $this->em->persist($record);
                $this->em->flush();
            } catch (\Exception $error) {
                return FALSE;
            }
        }
        else {
            return FALSE;
        }
    }

    public function createForm($request)
    {
        $book = [
            'authorName' => $request->request->get('authorName', NULL),
            'message' => $request->request->get('message', NULL),

        ];
        $form = $this->app['form.factory']->createBuilder('form', $book)
            ->add('authorName')
            ->add('message', 'textarea', ['label' => 'Сообщение', 'required' => TRUE])
            ->getForm();

        return $form;
    }
}