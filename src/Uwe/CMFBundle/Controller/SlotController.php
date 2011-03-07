<?php

namespace Uwe\CMFBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SlotController extends Controller
{
    /**
     * show action
     *
     * @param string $slot 
     * @return Response
     * @author Cludius, Sven
     */
    public function showAction($slot)
    {
        return $this->render($slot->getTemplate(), array('slot' => $slot));
    }
}
