<?php
namespace Bundle\MagazineBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\ClassMetadata;

class ArticleRepository extends \Doctrine\ODM\PHPCR\DocumentRepository
{
    private $class_name = 'Bundle\MagazineBundle\Document\Article';

    public function __construct($dm)
    {
        parent::__construct($dm, new ClassMetadata($this->class_name));
    }

    public function findAll()
    {
        $qm = $this->dm->getPhpcrSession()->getWorkspace()->getQueryManager();
        $sql = 'SELECT * FROM [nt:unstructured] WHERE _doctrine_alias = "article"';

        $results = $qm->createQuery($sql, \PHPCR\Query\QueryInterface::JCR_SQL2)->execute();
        $articles_list = array();

        foreach ($results as $article) {
          $articles_list[] = $this->createArticle($article->getNode());
        }

        return $articles_list;
    }

    public function createArticle($node, array &$hints = array())
    {
        return parent::createDocument($this->dm->getUnitOfWork(), $this->documentName, $node, $hints);
    }
}