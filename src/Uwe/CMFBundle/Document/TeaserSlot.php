<?php


namespace Uwe\CMFBundle\Document;

/** @phpcr:Document(alias="teaserslot", repositoryClass="Doctrine\ODM\PHPCR\DocumentRepository") */
class TeaserSlot extends Slot 
{
    /** @phpcr:String(name="heading") */
    protected $heading;
    /** @phpcr:String(name="text") */
    protected $text;

    public function __construct()
    {
        $this->template = 'CMFBundle:TeaserSlot:show.html.twig';
    }

    public function getHeading()
    {
        return $this->heading;
    }

    public function setHeading($heading)
    {
        $this->heading = $heading;
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
