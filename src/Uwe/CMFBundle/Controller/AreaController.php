<?php

namespace Uwe\CMFBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Uwe\CMFBundle\Document\Area;
use Uwe\CMFBundle\Form\PageForm;

class AreaController extends Controller
{

    public function showAction($path, $name)
    {
        $dm = $this->get('doctrine.phpcr_odm.document_manager');
        $area = $dm->find('Uwe\CMFBundle\Document\Area', $path. '/'. $name);
        if (!$area)
        {
            $area = new Area();
            $area->setPath($path.'/'.$name);
            $dm->persist($area, $path.'/'.$name);
            $dm->flush();
        }

        $children = $area->getNode()->getNodes();
        $slots = array();
        foreach ($children as $child)
        {
            $slots[] = $dm->getUnitOfWork()->createDocument(null, $child);
        }
        return $this->render('CMFBundle:Area:show.html.twig', array('area' => $area, 'slots' => $slots));
    }
}
