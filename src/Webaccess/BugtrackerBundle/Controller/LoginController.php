<?php

namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class LoginController extends Controller
{
    
    public function indexAction()
    {
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
 
        $aParams['last_username'] = $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME);
        $aParams['error'] = $error;
        return $this->render('WebaccessBugtrackerBundle:Dashboard:login.html.twig', $aParams);
    }
}
