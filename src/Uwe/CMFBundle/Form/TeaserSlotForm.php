<?php

namespace Uwe\CMFBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;

class TeaserSlotForm extends Form
{
    protected function configure()
    {
        // TODO select ...
        $this->add(new TextField('parent'));
        $this->add(new TextField('heading'));
        $this->add(new TextareaField('text'));
    }
}
