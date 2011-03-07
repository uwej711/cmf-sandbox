<?php


namespace Uwe\CMFBundle\Document;

/** @phpcr:Document(alias="slot", repositoryClass="Doctrine\ODM\PHPCR\DocumentRepository") */
class Slot 
{
    /** @phpcr:Path */
    protected $path;

    /** @phpcr:Node */
    protected $node;

    /** @phpcr:String(name="template") */
    protected $template;

    protected $parent;

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }
 
    public function getNode()
    {
        return $this->node;
    }

    public function setNode($node)
    {
        $this->node = $node;
    }
 
    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function getParent()
    {
      return $this->parent;
    }
    
    public function setParent($parent)
    {
      $this->parent = $parent;
    }  
}
