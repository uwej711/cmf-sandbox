<?php

namespace Uwe\CMFBundle\Services;

use Symfony\Component\Form\FormContext;
use Uwe\CMFBundle\Document\TeaserSlot;
use Uwe\CMFBundle\Form\TeaserSlotForm;

class TeaserSlotFactory implements SlotFactoryInterface
{
    protected $formContext;

    public function __construct(FormContext $formContext)
    {
        $this->formContext = $formContext;
    }

    public function createSlot()
    {
        return new TeaserSlot();
    }

    public function createForm()
    {
        return TeaserSlotForm::create($this->formContext, 'teaserslot');  
    }

    public function getCreateTemplate()
    {
        return 'CMFBundle:TeaserSlot:create.html.twig';
    }

}
