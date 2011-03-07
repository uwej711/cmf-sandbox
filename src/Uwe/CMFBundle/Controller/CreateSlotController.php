<?php

namespace Uwe\CMFBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Uwe\CMFBundle\Services\SlotFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ODM\PHPCR\DocumentManager;

class CreateSlotController
{
    protected $templating;
    protected $dm;
    protected $factory;
    protected $request;
    protected $router;

    public function __construct(TwigEngine $templating, DocumentManager $dm, SlotFactoryInterface $factory, Request $request, Router $router)
    {
        $this->templating = $templating;
        $this->dm = $dm;
        $this->factory = $factory;
        $this->request = $request;
        $this->router = $router;
    }
    
    public function create()
    {
        $slot = $this->factory->createSlot();
        $form = $this->factory->createForm();
        $form->bind($this->request, $slot);

        if ($form->isValid()) 
        {
            $area = $this->dm->find('Uwe\CMFBundle\Document\Area', $slot->getParent());
            if ($area)
            {
                $areaNode = $area->getNode();
                $children = $areaNode->getNodes();
                $name = 'slot-' . count($children);
             
                $this->dm->persist($slot, $area->getPath().'/'.$name);
                $this->dm->flush();

                return new RedirectResponse($this->router->generate('showpage', array('path' => ltrim($areaNode->getParent()->getPath(), '/'))));
            }
        }

        return new Response($this->templating->render($this->factory->getCreateTemplate(), array('form' => $form)));
    }
}
