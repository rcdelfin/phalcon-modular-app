<?php

/**
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Blog\Controller;

use Phalcon\Mvc\Controller;
use Blog\Entity\Post;
use Blog\Form\PostForm;

class AdminController extends Controller
{

    public function initialize()
    {
        $this->view->setLayout('admin');
    }

    public function indexAction()
    {
        $this->view->posts = Post::find(array('sort' => array('id'               => 'desc')));
        $this->view->title = 'Blog posts list';

    }

    public function addAction()
    {
        $this->view->pick(array('admin/edit'));

        $form = new PostForm();
        $post = new Post();

        if ($this->request->isPost()) {
            $form->bind($this->request->getPost(), $post);
            if ($form->isValid()) {
                if ($post->save() == true) {
                    $this->flash->success('Post added');
                    return $this->response->redirect('blog/admin/index');
                } else {
                    foreach ($post->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                }
            }
        }

        $this->view->title = 'Add blog post';
        $this->view->form  = $form;
    }

    public function editAction($id)
    {
        $id   = (int) $this->filter->sanitize($id, "int");
        $form = new PostForm();
        $post = Post::findFirst("id = {$id}");

        if ($this->request->isPost()) {
            $form->bind($this->request->getPost(), $post);
            if ($form->isValid()) {
                if ($post->save() == true) {
                    $this->flash->success('Post saved');
                    return $this->response->redirect('blog/admin/index');
                } else {
                    foreach ($post->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                }
            }
        } else {
            $form->setEntity($post);
        }

        $this->view->title = 'Edit blog post';
        $this->view->post = $post;
        $this->view->form  = $form;

    }

    public function deleteAction()
    {

    }

}