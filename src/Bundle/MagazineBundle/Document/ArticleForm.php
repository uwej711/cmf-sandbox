<?php

namespace Bundle\MagazineBundle\Document;

use Symfony\Component\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;

class ArticleForm extends \Symfony\Component\Form\Form
{
    protected function configure()
    {
        parent::configure();
        
        $this->add(new TextField('title'));
        $this->add(new TextareaField('body'));
    }
}
