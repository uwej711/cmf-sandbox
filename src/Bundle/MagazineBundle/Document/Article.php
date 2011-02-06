<?php

namespace Bundle\MagazineBundle\Document;

/** @phpcr:Document(repositoryClass="Doctrine\ODM\PHPCR\DocumentRepository", alias="article") */
class Article
{
    /** @phpcr:Path */
    public $path;

    /** @phpcr:Node */
    public $node;

    /** @phpcr:String(name="title") */
    public $title;

    /** @phpcr:String(name="body") */
    public $body;

    public $children;

    public function getChildren($repository)
    {
        if ($this->children)
        {
            return $this->children;
        }

        $children = $this->node->getNodes();

        foreach($children as $node)
        {
            $uow = $repository->getDocumentManager()->getUnitOfWork();
            $hints = array();
            $this->children[] = $uow->createDocument($repository->getDocumentName(), $node, $hints);
        }

        return $this->children;
    }
}
