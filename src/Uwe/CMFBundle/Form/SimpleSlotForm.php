<?php

namespace Uwe\CMFBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

class SimpleSlotForm extends Form
{
    protected function configure()
    {
        // TODO select ...
        $this->add(new TextField('parent'));
        $this->add(new TextField('text'));
    }
}
