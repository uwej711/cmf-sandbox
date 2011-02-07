<?php

namespace Bundle\MagazineBundle\Controller;

use Bundle\MagazineBundle\Document\Article;
use Bundle\MagazineBundle\Document\ArticleForm;
use Bundle\MagazineBundle\Document\ArticleRepository;
use Bundle\MagazineBundle\Document\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function newDocumentAction()
    {
        $form = ArticleForm::create($this->get('form.context'), 'article');

        return $this->render('MagazineBundle:Default:new.html.twig', array('form' => $form));
    }

    public function setDocumentAction()
    {
        $article = new Article();
        $form = ArticleForm::create($this->get('form.context'), 'article');

        $form->bind($this->get('request'), $article);

        if (!$form->isValid()) {
          return $this->render('MagazineBundle:Default:new.html.twig', array('form' => $form));
        }

        $path = $this->get('request')->request->get($form->getName(), '/');

        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $dm->persist($article, rtrim($path['path'], '/').'/'.$article->title);
        $dm->flush();

        return $this->render('MagazineBundle:Default:show.html.twig', array('article' => $article));
    }

    public function listDocumentAction()
    {
        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $repository = new ArticleRepository($dm);
        
        return $this->render('MagazineBundle:Default:list.html.twig', array('articles' => $repository->findAll()));
    }


    public function getDocumentAction($title)
    {
        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $article = $dm->find('Bundle\MagazineBundle\Document\Article', '/'.$title);

        return $this->render('MagazineBundle:Default:show.html.twig', array('article' => $article));
    }

    public function removeDocumentAction($title)
    {
        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');

        $article = $dm->find('Bundle\MagazineBundle\Document\Article', '/'.$title);
        $dm->remove($article);
        $dm->flush();

        return new \Symfony\Component\HttpFoundation\Response('Deleted');
    }

    public function newFolderAction($name)
    {
        $folder = new Folder();
        $folder->name = $name;

        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $dm->persist($folder, '/'.$name);

        try {
            $dm->flush();
        } catch (\Exception $e) {
            $folders = $dm->find('Bundle\MagazineBundle\Document\Folder', '/'.$name);
            
            if ($folder instanceof \Bundle\MagazineBundle\Document\Folder) {
                return new \Symfony\Component\HttpFoundation\Response('Folder already exists');
            }

            return new \Symfony\Component\HttpFoundation\Response($e->getMessage());
        }

        return $this->forward('MagazineBundle:Default:browse');
    }

    public function browseAction($folder = '/')
    {
        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $folder_node = $dm->find('Bundle\MagazineBundle\Document\Folder', $folder);

        if (empty($folder_node)) {
            return new \Symfony\Component\HttpFoundation\Response('Not found', 404);
        }
        
        return $this->render('MagazineBundle:Default:browse.html.twig', array('folders' => $folder_node->getChildren($dm)));
    }
}
