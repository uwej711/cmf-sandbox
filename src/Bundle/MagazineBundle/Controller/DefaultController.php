<?php

namespace Bundle\MagazineBundle\Controller;

use Bundle\MagazineBundle\Document\Article;
use Bundle\MagazineBundle\Document\ArticleForm;
use Bundle\MagazineBundle\Document\ArticleRepository;
use Bundle\MagazineBundle\Document\Folder;
use Bundle\MagazineBundle\Document\FolderForm;
use Bundle\MagazineBundle\Document\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Display empty form for new article
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newDocumentAction()
    {
        $form = ArticleForm::create($this->get('form.context'), 'article');

        return $this->render('MagazineBundle:Default:new.html.twig', array('form' => $form));
    }

    /**
     * Display empty form for new article
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newFolderAction()
    {
        $form = FolderForm::create($this->get('form.context'), 'folder');

        return $this->render('MagazineBundle:Default:new_folder.html.twig', array('form' => $form));
    }

    /**
     * Store a new Article from request parameter
     *
     * @see newDocumentAction()
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

        return $this->render('MagazineBundle:Default:show_'.$this->getTemplateName($article).'.html.twig', array('document' => $article));
    }

    /**
     * Store a new Folder from request parameter
     *
     * @see newDocumentAction()
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setFolderAction()
    {
        $folder = new Folder();
        $form = FolderForm::create($this->get('form.context'), 'folder');

        $form->bind($this->get('request'), $folder);

        if (!$form->isValid()) {
          return $this->render('MagazineBundle:Default:new_folder.html.twig', array('form' => $form));
        }

        $path = $this->get('request')->request->get($form->getName(), '/');

        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $dm->persist($folder, rtrim($path['path'], '/').'/'.$folder->name);

        try {
            $dm->flush();
        } catch (\Exception $e) {
            $repository = new DocumentRepository($dm);

            if (is_null($repository->find('/'.$name))) {
                return new \Symfony\Component\HttpFoundation\Response('Folder already exists');
            }

            return new \Symfony\Component\HttpFoundation\Response($e->getMessage());
        }

        return $this->render('MagazineBundle:Default:show_'.$this->getTemplateName($folder).'.html.twig', array('document' => $folder));
    }

    /**
     * Display document from its path
     *
     * @param string $path
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showDocumentAction($path)
    {
        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');

        $repository = new DocumentRepository($dm);
        $document = $repository->find('/'.$path);
//        var_dump($document); die();

        return $this->render('MagazineBundle:Default:show_'.$this->getTemplateName($document).'.html.twig', array('document' => $document));
    }

    /**
     * Remove a document from repository
     *
     * @param string $title
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeDocumentAction($title)
    {
        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');

        $repository = new DocumentRepository($dm);
        $document = $repository->find('/'.$title);
        $dm->remove($document);
        $dm->flush();

        return new \Symfony\Component\HttpFoundation\Response('Deleted');
    }

    /**
     * Display list of documents
     *
     * @param string $folder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listDocumentAction($folder = '/')
    {
        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $repository = new DocumentRepository($dm);

        return $this->render('MagazineBundle:Default:list.html.twig', array('documents' => $repository->findAll()));
    }

    /**
     * Returns the name of the document
     *
     * @param <type> $document
     * @return string template name
     */
    public function getTemplateName($document)
    {
      $class = explode('\\', (is_string($document) ? $document : get_class($document)));

      return strtolower($class[count($class) - 1]);
    }
}
