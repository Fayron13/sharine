<?php

namespace SHARINE\CategorieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SHARINECategorieBundle:Default:index.html.twig', array('name' => $name));
    }
}
