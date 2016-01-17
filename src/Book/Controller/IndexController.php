<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16.01.16
 * Time: 18:29
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Index Controller Provider
 *
 */
class IndexController implements ControllerProviderInterface
{

    /**
     * Index Connect
     *
     * @param Application $app
     * @return mixed
     */
    public function connect(Application $app)
    {
        $indexController = $app['controllers_factory'];

        $indexController->get('/', function () use ($app) {
            return $app['twig']->render('index.html.twig');
        })->bind('home');

        // Вызов сортированного списка
        $indexController->get('/books', function (Request $request) use ($app) {
            $book = [
                'publication_at' => $request->query->get('publication_at', NULL),
                'like_count' => $request->query->get('like_count', NULL),
            ];
            $books = $app['bookService']->readSort($book);
            $output = $app['twig']->render('books.html.twig', [
                'books' => $books,
                'book' => $book
            ]);

            return $output;

        })->bind('books');

        //Просмотр отзыва
        $indexController->get('/book/{id}', function (Request $request, $id) use ($app) {
            $getBook = [
                'publication_at' => $request->query->get('publication_at', NULL),
                'like_count' => $request->query->get('like_count', NULL),
            ];
            $book = $app['bookService']->readOne($id);
            $sortId = $app['bookService']->readSortId($id, $getBook);
            return $app['twig']->render('book.html.twig', [
                'book' => $book,
                'getBook' => $getBook,
                'sortId' => $sortId
            ]);

        })->bind('show');

        //Создание нового отзыва
        $app->match('/create', function (Request $request) use ($app) {
            $form = $app['bookService']->createForm($request);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = array_merge($form->getData(), ['authorIp' => $request->getClientIp()]);
                $app['bookService']->save($data);

                return $app->redirect('/books');
            }

            return $app['twig']->render('create.html.twig', [
                'form' => $form->createView()
            ]);
        })->bind('create');

        // создание лайка
        $indexController->get('/likeip/book/{id}', function (Request $request, $id) use ($app) {
            $book = [
                'publication_at' => $request->query->get('publication_at', NULL),
                'like_count' => $request->query->get('like_count', NULL),
            ];
            $getString = '?publication_at=' . $book['publication_at'] .
                '&like_count=' . $book['like_count'];
            $data = ['likeIp' => $request->getClientIp()];
            $app['bookService']->likeIpSave($id, $data);
            $redirec = '/books' . $getString;

            return $app->redirect($redirec);
        })->bind('likeip');

        return $indexController;
    }
}