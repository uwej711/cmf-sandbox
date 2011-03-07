<?php

namespace Uwe\CMFBundle\Services;

use Symfony\Component\Form\FormContext;
use Uwe\CMFBundle\Document\SimpleSlot;
use Uwe\CMFBundle\Form\SimpleSlotForm;

class SimpleSlotFactory implements SlotFactoryInterface
{
    protected $formContext;

    public function __construct(FormContext $formContext)
    {
        $this->formContext = $formContext;
    }

    public function createSlot()
    {
        return new SimpleSlot();
    }

    public function createForm()
    {
        return SimpleSlotForm::create($this->formContext, 'simpleslot');  
    }

    public function getCreateTemplate()
    {
        return 'CMFBundle:SimpleSlot:create.html.twig';
    }

}
