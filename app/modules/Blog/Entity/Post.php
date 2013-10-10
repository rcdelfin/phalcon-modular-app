<?php

/**
 * News
 * @copyright Copyright (c) 2011 - 2012 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Blog\Entity;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Application\I18n\Transliterator;

class Post extends Model
{

    public $id;
    public $slug;
    public $title;
    public $text;
    public $created_at;
    public $updated_at;

    public function getSource()
    {
        return "blog_posts";
    }

    public function initialize()
    {
        $this->addBehavior(new Timestampable(
                array(
            'beforeCreate' => array(
                'field'  => 'created_at',
                'format' => 'Y-m-d H:i:s'
            ),
            'beforeUpdate' => array(
                'field'  => 'updated_at',
                'format' => 'Y-m-d H:i:s'
            ),
                )
        ));

    }

    public function validate()
    {

    }

    public function afterValidation()
    {
        $this->setSlug(Transliterator::slugify($this->getTitle()));

    }

    public function getId()
    {
        return $this->id;

    }

    public function setId($id)
    {
        $this->id = $id;

    }

    public function getTitle($filtration = false)
    {
        if ($filtration) {
            return $this->geterFiltration($this->title);
        }
        return $this->title;

    }

    public function setTitle($title)
    {
        $this->title = $this->seterFiltration($title);

    }

    public function getText()
    {
        return $this->text;

    }

    public function setText($text)
    {
        $this->text = $text;

    }

    private function seterFiltration($string)
    {
        return trim(htmlspecialchars(strip_tags($string)));

    }

    private function geterFiltration($string)
    {
        return html_entity_decode($string);

    }

    public function getSlug()
    {
        return $this->slug;

    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

    }

    public function getCreatedAt()
    {
        return $this->created_at;

    }

    public function getUpdatedAt()
    {
        return $this->updated_at;

    }

    public function getCharsCount()
    {
        return mb_strlen(strip_tags($this->getText(), 'utf-8'));
    }

}