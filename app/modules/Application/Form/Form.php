<?php

/**
 * Form
 * @copyright Copyright (c) 2011 - 2013 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Application\Form;

use \Phalcon\Forms\Element\Hidden;
use \Phalcon\Forms\Element\Check;
use \Phalcon\Forms\Element\Submit;

class Form extends \Phalcon\Forms\Form
{

    public function renderDecorated($name, $decorator = 'block')
    {
        $element = $this->get($name);

        $messages = $this->getMessagesFor($element->getName());

        $html = '';

        if (count($messages)) {
            $html .= '<div class="alert alert-danger">';
            foreach ($messages as $message) {
                $html .= $message;
            }
            $html .= '</div>';
        }

        if ($element instanceof Hidden) {
            echo $element;
        } else {
            switch ($decorator) {
                case 'block' : {
                        switch (true) {
                            case $element instanceof Check : {
                                    $html .= '<div class="checkbox">';
                                    $html .= '<label>';
                                    $html .= $element;
                                    $html .= $element->getLabel();
                                    $html .= '</label>';
                                    $html .= '</div>';
                                    break;
                                }
                            case $element instanceof Submit : {
                                    $html .= '<div class="form-group">';
                                    $html .= $element->getLabel();
                                    $html .= $element;
                                    $html .= '</div>';
                                    break;
                                }
                            default : {
                                    $element->setAttribute('class', 'form-control');
                                    $html .= '<div class="form-group">';
                                    $html .= '<label for="' . $element->getName() . '">' . $element->getLabel() . '</label>';
                                    $html .= $element;
                                    $html .= '</div>';
                                    break;
                                }
                        }
                        break;
                    }
                case 'horizontal' : {
                        switch (true) {
                            case $element instanceof Check : {
                                    $html .= '<div class="checkbox">';
                                    $html .= '<label class="checkbox">' . $element->getLabel();
                                    $html .= $element;
                                    $html .= '</label>';
                                    $html .= '</div>';
                                    break;
                                    break;
                                }
                            default : {
                                    $html .= '<div class="form-group">';
                                    $html .= '<label class="control-label" for="' . $element->getName() . '">' . $element->getLabel() . '</label>';
                                    $html .= '<div class="controls">';
                                    $html .= $element;
                                    $html .= '</div>';
                                    $html .= '</div>';
                                }
                        }
                        break;
                    }
            }
        }

        return $html;

    }

}