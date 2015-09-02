<?php

namespace SHARINE\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SHARINE\ArticleBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction($categorie=null, Request $request)
    {
        if(isset($categorie) and $categorie != null){
            $articles = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article')->getAllArticles($categorie);
        }else{
            $articles = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article')->getAllArticles();
        }
        $categories = $this->getDoctrine()->getManager()->getRepository('SHARINECategorieBundle:Categorie')->getAllCategories();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($articles, $this->get('request')->query->get('page', 1), 5);

        return $this->render('SHARINEUserBundle:Home:accueil.html.twig', array(
            'categorie' => $categories,
            'article' => $articles,
            'pagination' => $pagination
        ));
    }

    public function connexionAction(){
        return $this->render('SHARINEUserBundle:Security:login.html.twig');

    }

    public function administrationAction($categorie=null){
        if(isset($categorie) and $categorie != null){
            $articles = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article')->getAllArticlesAdmin($categorie);
        }else{
            $articles = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article')->getAllArticlesAdmin();
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($articles, $this->get('request')->query->get('page', 1), 5);
        $categories = $this->getDoctrine()->getManager()->getRepository('SHARINECategorieBundle:Categorie')->getAllCategories();

        return $this->render('SHARINEUserBundle:Home:accueil.html.twig', array(
            'categorie' => $categories,
            'article' => $articles,
            'pagination' => $pagination
        ));
    }
}
