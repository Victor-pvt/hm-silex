<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16.01.16
 * Time: 18:29
 */

namespace Controller;
use Entity\Book;
use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Index Controller Provider
 *
 */
class IndexController implements ControllerProviderInterface {

    /**
     * Index Connect
     *
     * @param Application $app
     * @return mixed
     */
    public function connect(Application $app)
    {
        $indexController = $app['controllers_factory'];

        $indexController->get('/', function() use ($app)
        {
            return $app['twig']->render('index.html.twig');
        })->bind('home');

        //Просмотр списка отзывов
        $indexController->get('/books', function(Request $request) use ($app)
        {
            $books = $app['bookService']->read($request);
            return $app['twig']->render('books.html.twig', [
                'books' => $books
            ]);
        })->bind('books');

        //Просмотр отзыва
        $indexController->get('/book/{id}', function($id) use ($app)
        {
            $book = $app['bookService']->readOne($id);
            $prev = $app['bookService']->readOnePrev($id);
            $next = $app['bookService']->readOneNext($id);
            return $app['twig']->render('book.html.twig', [
                'book' => $book,
                'prev' => $prev,
                'next' => $next,
            ]);

        })->bind('show');

        //Создание нового отзыва
        $app->match('/create', function (Request $request) use ($app) {
            $form = $app['bookService']->createForm($request);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = array_merge($form->getData(),['authorIp' => $request->getClientIp()]);
                $app['bookService']->save($data);
                return $app->redirect('/books');
            }
            return $app['twig']->render('create.html.twig', [
                'form' => $form->createView()
            ]);
        })->bind('create');

        $indexController->get('/likeip/book/{id}', function(Request $request, $id) use ($app)
        {
            $data = ['likeIp' => $request->getClientIp()];
            $app['bookService']->likeIpSave($id, $data);
            return $app->redirect('/books');
        })->bind('likeip');

        return $indexController;
    }
}