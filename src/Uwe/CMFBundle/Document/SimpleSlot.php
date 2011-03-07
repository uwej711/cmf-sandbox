<?php


namespace Uwe\CMFBundle\Document;

/** @phpcr:Document(alias="simpleslot", repositoryClass="Doctrine\ODM\PHPCR\DocumentRepository") */
class SimpleSlot extends Slot
{
    /** @phpcr:String(name="text") */
    protected $text;

    public function __construct()
    {
        $this->template = 'CMFBundle:SimpleSlot:show.html.twig';
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }
}
