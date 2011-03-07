<?php

namespace Uwe\CMFBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Uwe\CMFBundle\Document\Page;
use Uwe\CMFBundle\Form\PageForm;

class PageController extends Controller
{
    public function createAction()
    {
        $page = new Page();

        $form = PageForm::create($this->get('form.context'), 'page');
        $form->bind($this->get('request'), $page);

        if ($form->isValid()) {
            $dm = $this->get('doctrine.phpcr_odm.document_manager');
            $dm->persist($page, $page->getPath());
            $dm->flush();
            return new RedirectResponse($this->generateUrl('showpage', array('path' => ltrim($page->getPath(), '/'))));
        }

        return $this->render('CMFBundle:Page:create.html.twig', array('form' => $form));
    }


    public function showAction($path)
    {
        $dm = $this->get('doctrine.phpcr_odm.document_manager');
        $page = $dm->find('Uwe\CMFBundle\Document\Page', $path);
        if ($page)
        {
            return $this->render('CMFBundle:Page:show.html.twig', array('page' => $page));
        }
        else
        {
            throw new NotFoundHttpException();
        }
    }
}
