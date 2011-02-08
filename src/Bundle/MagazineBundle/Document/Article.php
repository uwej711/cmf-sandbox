<?php

namespace Bundle\MagazineBundle\Document;

/** @phpcr:Document(repositoryClass="Doctrine\ODM\PHPCR\DocumentRepository", alias="article") */
class Article
{
    /** @phpcr:Path */
    public $path;

    /** @phpcr:Node */
    public $node;

    /**
     * @phpcr:String(name="title")
     * @validation:MinLength(3)
     * @validation:MaxLength(30)
     */
    public $title;

    /**
     * @phpcr:String(name="body")
     * @validation:NotBlank
     */
    public $body;

    public function getPathWithoutRoot()
    {
      return ltrim($this->path, '/');
    }

    public function __toString()
    {
      return $this->title;
    }
}
