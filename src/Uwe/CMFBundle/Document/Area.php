<?php

namespace Uwe\CMFBundle\Document;

/** @phpcr:Document(alias="area", repositoryClass="Doctrine\ODM\PHPCR\DocumentRepository") */
class Area 
{
  /** @phpcr:Path */
  private $path;

  /** @phpcr:Node */
  private $node;

  private $slots = null;

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

}
