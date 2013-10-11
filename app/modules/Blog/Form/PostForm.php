<?php

/**
 * PostForm
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Blog\Form;

use Application\Form\Form;

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Submit;

use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class PostForm extends Form
{

    public function initialize()
    {
        $title = new Text("title", array('required' => true));
        $title->addValidator(new PresenceOf(array('message' => 'Title is required')));
        $title->addValidator(new StringLength(array(
            'min' => 3,
            'messageMinimum' => 'The title is too short'
        )));
        $title->setLabel('Title');

        $text = new TextArea("text", array('rows' => 3));
        $text->setLabel('Text');

        $submit = new Submit("submit", array(
            'value' => 'Save',
            'class' => 'btn btn-primary',
            'style' => 'width: 200px'
        ));

        $this->add($title);
        $this->add($text);
        $this->add($submit);

    }

}