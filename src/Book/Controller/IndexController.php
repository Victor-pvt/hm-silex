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

        $indexController->get('/books', function() use ($app)
        {
            $books = $app['bookService']->read();
            return $app['twig']->render('books.html.twig', [
                'books' => $books
            ]);
        })->bind('books');
        //Просмотр списка отзывов

        $indexController->get('/book/{id}', function($id) use ($app)
        {
            $book = $app['bookService']->readOne($id);
            return $app['twig']->render('book.html.twig', [
                'book' => $book
            ]);

        })->bind('show');
//Просмотр отзыва

//Создание нового отзыва
        $app->match('/create', function (Request $request) use ($app) {
            $book = [
            'authorName' => $request->request->get('authorName', null),
            'message' => $request->request->get('message', null),
            ];

            $form = $app['form.factory']->createBuilder('form', $book )
                ->add('authorName')
                ->add('message' , 'textarea', ['label' => 'Сообщение', 'required' => true])
                ->getForm();

            $form->handleRequest($request);

            if ($form->isValid()) {
                $book = new Book($app);
                $data = $form->getData();
                $app['bookService']->save($data);

                // redirect somewhere
                return $app->redirect('/');
            }
            //return $app->redirect('/hello');

            return $app['twig']->render('create.html.twig', [
                'book' => $book,
                'form' => $form->createView()
            ]);
        })->bind('create');
        return $indexController;
    }
}