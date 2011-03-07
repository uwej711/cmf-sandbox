<?php

namespace Uwe\CMFBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;

class PageForm extends Form
{
    protected function configure()
    {
        $this->add(new TextField('path'));
        $this->add(new TextField('title'));
        $this->add(new TextareaField('description'));
        $this->add(new TextareaField('keywords'));
    }
}
