<?php

namespace Bundle\MagazineBundle\Controller;

use Bundle\MagazineBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function newDocumentAction()
    {
        $form = \Bundle\MagazineBundle\Document\ArticleForm::create($this->get('form.context'), 'article');

        return $this->render('MagazineBundle:Default:fill_form.html.twig', array('form' => $form));
    }

    public function setDocumentAction()
    {
        $article = new \Bundle\MagazineBundle\Document\Article();
        $form = \Bundle\MagazineBundle\Document\ArticleForm::create($this->get('form.context'), 'article');

        $form->bind($this->get('request'), $article);

        if (!$form->isValid()) {
          return $this->render('MagazineBundle:Default:fill_form.html.twig', array('form' => $form));
        }

        $path = $this->get('request')->request->get($form->getName(), '/');

        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $dm->persist($article, rtrim($path['path'], '/').'/'.$article->title);
        $dm->flush();

        return $this->render('MagazineBundle:Default:index.html.twig', array('article' => $article));
    }

    public function listDocumentAction()
    {
        $root_node = $this->container->get('doctrine.phpcr_odm.document_manager')->getPhpcrSession()->getRootNode();

        //$sql = 'SELECT * FROM [nt:unstructured]';
        //$articles = $qm->createQuery($sql, 'JCR-SQL2')->execute();
        $articles_list = array();
        
        foreach ($root_node->getNodes('A*') as $article) {
          $articles_list[] = $article->getProperty('title')->getString();
        }

        return $this->render('MagazineBundle:Default:list.html.twig', array('articles' => $articles_list));
    }



    public function getDocumentAction($title)
    {
        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $article = $dm->find('Bundle\MagazineBundle\Document\Article', '/'.$title);

        return new \Symfony\Component\HttpFoundation\Response($article->title);
    }

    public function removeDocumentAction($title)
    {
        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');

        $article = $dm->find('Bundle\MagazineBundle\Document\Article', '/'.$title);
        $dm->remove($article);
        $dm->flush();

        return new \Symfony\Component\HttpFoundation\Response('Deleted');
    }
}
