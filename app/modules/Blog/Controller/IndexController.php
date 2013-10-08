<?php

/**
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Blog\Controller;

use Phalcon\Mvc\Controller;
use Blog\Entity\Post;

class IndexController extends Controller
{

    public function indexAction()
    {
        $posts = Post::find(array('sort' => array('created_at' => 'desc')));

        $this->view->posts = $posts;

    }

    public function postAction($slug)
    {
        echo $slug, "post"; exit;
        $slug = $this->dispatcher->getParam("slug");

        $entity = Post::findFirst(array("slug = '{$slug}'",
                    'cache' => array(
                        "lifetime" => 30,
                        "key"      => "Post::findBySlug(" . md5($slug) . ")"
        )));
        if (!$entity) {
            $this->response->redirect('/');
            return false;
        }

        $this->view->entity = $entity;

    }

}