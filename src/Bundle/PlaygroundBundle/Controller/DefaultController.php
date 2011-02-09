<?php

namespace Bundle\PlaygroundBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Bundle\PlaygroundBundle\Document\User;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

class DefaultController extends Controller
{
    public function createWorkspaceAction($name)
    {
        $user = new User();
        $user->name = 'prova';
        $user->email = 'francesco@example.com';

        $form = new Form('user');
        $form->add(new TextField('name'));
        $form->add(new TextField('email'));
        $form->bind(new \Symfony\Component\HttpFoundation\Request, $user);

        return $this->render('PlaygroundBundle:Default:form.html.twig', array('form' => $form)); 
    }

    public function getDocumentChildrenAction($parent)
    {
        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $repository = $dm->getRepository('Bundle\PlaygroundBundle\Document\User');
        $user = $repository->find('/'.$parent);

        foreach($user->getChildren($repository, $dm) as $child) {
            echo $child->username;
        }

        return new \Symfony\Component\HttpFoundation\Response($user->username);
    }

    public function setDocumentChildAction($parent, $username)
    {
        $document = new \Bundle\PlaygroundBundle\Document\User;
        $document->username = $username;

        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $dm->persist($document, '/'.$parent.'/'.$username);
        $dm->flush();

        return new \Symfony\Component\HttpFoundation\Response('Ok');
    }

    public function setDocumentAction($username)
    {
        $document = new \Bundle\PlaygroundBundle\Document\User;
        $document->username = $username;

        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $dm->persist($document, '/'.$username);
        $dm->flush();

        return new \Symfony\Component\HttpFoundation\Response('Ok');
    }

    public function getDocumentAction($username)
    {
        $dm = $this->container->get('doctrine.phpcr_odm.document_manager');
        $user = $dm->find('Bundle\PlaygroundBundle\Document\User', '/'.$username);

        return new \Symfony\Component\HttpFoundation\Response($user->username);
    }

    public function indexAction($name)
    {


        return $this->render('PlaygroundBundle:Default:index.html.twig', array('name' => $name));


    }
}
