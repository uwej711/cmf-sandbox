<?php
namespace Bundle\MagazineBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\ClassMetadata;

class FolderRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    private $class_name = 'Bundle\MagazineBundle\Document\Folder';

    public function __construct($dm)
    {
        parent::__construct($dm, new ClassMetadata($this->class_name));
    }

    public function findAll($path = null)
    {
        $qm = $this->dm->getPhpcrSession()->getWorkspace()->getQueryManager();
        $sql = 'SELECT * FROM [nt:unstructured] WHERE _doctrine_alias = "folder"';
        if (!\is_null($path)) {
          $sql.= ' AND path LIKE "'.$path.'%"';
        }

        $results = $qm->createQuery($sql, \PHPCR\Query\QueryInterface::JCR_SQL2)->execute();
        $Folders_list = array();

        foreach ($results as $Folder) {
          $Folders_list[] = $this->createFolder($Folder->getNode());
        }

        return $Folders_list;
    }

    public function createFolder($node, array &$hints = array())
    {
        return parent::createDocument($this->dm->getUnitOfWork(), $this->documentName, $node, $hints);
    }

}