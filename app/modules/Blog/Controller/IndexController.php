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

    }

    public function postAction()
    {
        $slug   = $this->dispatcher->getParam("slug");
        $entity = Post::findFirst("slug = $slug", array(
                    'cache' => array(
                        "lifetime" => 30,
                        "key"      => "Post::findBySlug(" . md5($slug) . ")"
                    )
        ));
        if (!$entity) {
            return $this->response->redirect('/');
        }

        $this->view->entity = $entity;

    }

}