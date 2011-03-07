<?php

namespace Uwe\CMFBundle\Document;

/** @phpcr:Document(alias="page", repositoryClass="Doctrine\ODM\PHPCR\DocumentRepository") */
class Page 
{
  /** @phpcr:Path */
  private $path;

  /** @phpcr:Node */
  private $node;

  /** @phpcr:String(name="title") */
  private $title;

  /**  @phpcr:String(name="keywords") */
  private $keywords;

  /**  @phpcr:String(name="description") */
  private $description;

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
 
  public function getTitle()
  {
    return $this->title;
  }

  public function setTitle($title)
  {
    $this->title = $title;
  }

  public function getKeywords()
  {
    return $this->keywords;
  }

  public function setKeywords($keywords)
  {
    $this->keywords = $keywords;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function setDescription($description)
  {
    $this->description = $description;
  }

}
