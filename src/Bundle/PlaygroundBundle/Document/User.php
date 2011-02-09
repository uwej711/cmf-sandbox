<?php

namespace Bundle\PlaygroundBundle\Document;

/** @phpcr:Document(repositoryClass="Doctrine\ODM\PHPCR\DocumentRepository", alias="user") */
class User
{
    /** @phpcr:Path */
    public $path;

    /** @phpcr:Node */
    public $node;

    /** @phpcr:String(name="username") */
    public $username;

    /** @phpcr:String(name="email") */
    public $email;

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
