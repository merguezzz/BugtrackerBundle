<?php

namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('WebaccessBugtrackerBundle:Dashboard:index.html.twig');
    }
}