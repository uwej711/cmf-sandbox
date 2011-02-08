<?php
namespace Bundle\MagazineBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\ClassMetadata;

class DocumentRepository
{
    private $dm;
    private $dr;

    public function __construct($dm)
    {
        $this->dm = $dm;
    }

    public function findAll($path = null)
    {
        $qm = $this->dm->getPhpcrSession()->getWorkspace()->getQueryManager();
        $sql = 'SELECT * FROM [nt:unstructured] WHERE _doctrine_alias <> ""';
        if (!\is_null($path)) {
            $sql.= ' AND path LIKE "'.$path.'%"';
        }

        $results = $qm->createQuery($sql, \PHPCR\Query\QueryInterface::JCR_SQL2)->execute();
        $documents = array();

        foreach ($results as $row) {
            $documents[] = $this->createDocument($row ->getNode());
        }

        $documents = \array_filter($documents);

        return $documents;
    }

    public function createDocument($node, array &$hints = array())
    {
        if (!$this->isDocument($node)) {
            return null;
        }

        $class_name = $node->getPropertyValue('_doctrine_alias');

        return $this->dm->getUnitOfWork()->createDocument('Bundle\MagazineBundle\Document\\'.$class_name, $node, $hints);
    }

    private function isDocument($node)
    {
        return $node->hasProperty('_doctrine_alias');
    }

    public function find($path)
    {
        try {
            return $this->createDocument($this->dm->getPhpcrSession()->getNode($path))  ;
        } catch (\PHPCR\PathNotFoundException $e) {
            return null;
        }
    }

}