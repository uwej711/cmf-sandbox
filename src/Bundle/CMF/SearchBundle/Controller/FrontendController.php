<?php

namespace Bundle\CMF\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontendController extends Controller
{
    public function indexAction()
    {
        $form = $this->get('cmf_search.form.search');
        
        return $this->render('CMFSearchBundle:Search:index.html.twig', array('form' => $form, 'results' => array()));
    }

    public function searchAction()
    {
        $form = $this->get('cmf_search.form.search');
        $form->bind($this->get('request'));

        $results = array();
        if($form->isValid()) {
            $queryManager = $this->get('jackalope.session')->getWorkspace()->getQueryManager();
            $sql = sprintf("SELECT * FROM [nt:unstructured] WHERE name LIKE '%s'", '%'.$form->get('keywords')->getData().'%');
            if($logger = $this->get('logger')) {
                $logger->debug($sql);
            }
            $query = $queryManager->createQuery($sql, 'JCR-SQL2');
            $results = $query->execute();
        }

        return $this->render('CMFSearchBundle:Search:index.html.twig', array('form' => $form, 'results' => $results));
    }
}
