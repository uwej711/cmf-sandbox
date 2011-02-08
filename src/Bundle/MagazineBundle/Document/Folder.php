<?php

namespace Bundle\MagazineBundle\Document;

/** @phpcr:Document(repositoryClass="Doctrine\ODM\PHPCR\DocumentRepository", alias="folder") */
class Folder
{
    /** @phpcr:Path */
    public $path;

    /** @phpcr:Node */
    public $node;

    /**
     * @phpcr:String(name="name")
     * @validation:NotBlank
     */
    public $name;

    public $children = array();

    public function getChildren($dm)
    {
        if ($this->children) {
            return $this->children;
        }

        foreach($this->node->getNodes() as $node) {
            if ($this->isFolderNode($node)) {
                $this->children[] = $dm->getUnitOfWork()->createDocument('Bundle\MagazineBundle\Document\Folder', $node);
            }
        }

        return $this->children;
    }

    public function getPathWithoutRoot()
    {
      return ltrim($this->path, '/');
    }

    private function isFolderNode($node)
    {
      return $node->hasProperty('_doctrine_alias') && $node->getPropertyValue('_doctrine_alias') === 'folder';
    }

    public function __toString()
    {
      return $this->name ?: 'n/a';
    }

}
