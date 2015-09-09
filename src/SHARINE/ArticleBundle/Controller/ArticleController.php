<?php

namespace SHARINE\ArticleBundle\Controller;
use SHARINE\ArticleBundle\Entity\Article;
use SHARINE\ArticleBundle\Entity\Commentaire;
use SHARINE\ArticleBundle\Form\ArticleType;
use SHARINE\ArticleBundle\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class ArticleController extends Controller
{
    public function NouveauAction(Request $request)
    {
        $articleType = new Article();
        $form = $this->get('form.factory')->create(new ArticleType(), $articleType);
        $user = $this->getDoctrine()->getManager()->getRepository('SHARINEUserBundle:User')->find($this->container->get('security.context')->getToken()->getUser()->getId());

        if ($form->handleRequest($request)->isValid()) {
            $articleType->setDate(new \Datetime());
            $articleType->setUser($user);
            $articleType->setIsActive(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($articleType);
            $em->flush();

            return $this->redirect($this->generateUrl('sharine_user_homepage'));
        }

        return $this->render('SHARINEArticleBundle:Article:nouveau.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function mesPublicationAction(){

        $user = $this->container->get('security.context')->getToken()->getUser();
        $user->getId();

        $articles = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article')->getArticlesByIdUser($user);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($articles, $this->get('request')->query->get('page', 1), 5);
        $categories = $this->getDoctrine()->getManager()->getRepository('SHARINECategorieBundle:Categorie')->getAllCategories();

        return $this->render('SHARINEUserBundle:Home:accueil.html.twig', array(
            'categorie' => $categories,
            'article' => $articles,
            'pagination' => $pagination,
            'menu_cat' => "menu_cat"
        ));

    }

    public function administrationAction(){
        $message = \Swift_Message::newInstance()

            ->setContentType('text/html')

            ->setSubject('coucou')

            ->setFrom('warstratgaming@gmail.com')

            ->setTo('maho.arthur.13@gmail.com')

            ->setBody('Bonjour');


        $this->get('mailer')->send($message);
        return $this->render('SHARINEUserBundle:Registration:checkEmail.html.twig');
    }

    public function publicationAction($id=null,Request $request){
        $user = $this->getDoctrine()->getManager()->getRepository('SHARINEUserBundle:User')->find($this->container->get('security.context')->getToken()->getUser()->getId());
        $commentaireType = new Commentaire();
        $form = $this->get('form.factory')->create(new CommentaireType(), $commentaireType);
        $articles = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article')->getArticlesByIdArticle($id);
        $commentaires = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Commentaire')->getCommentairesByArticle($id);
        if ($form->handleRequest($request)->isValid()) {
            $commentaireType->setDate(new \Datetime("now"));
            $commentaireType->setUser($user);
            $commentaireType->setArticle($this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article')->find($id));
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaireType);
            $em->flush();
            header("location: ".$request->getUri());
            exit();

        }



        return $this->render('SHARINEArticleBundle:Article:bodyArticle.html.twig', array(
            'id' => $id,
            'article' => $articles,
            'commentaires' => $commentaires,
            'form' => $form->createView(),
//            'pagination' => $pagination
        ));
    }

    public function publicationAdminAction($id=null){
        $articles = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article')->getArticlesByIdArticle($id);
        return $this->render('SHARINEArticleBundle:Article:bodyArticle.html.twig', array(
            'id' => $id,
            'article' => $articles
        ));
    }

    public function validerPublicationAction($id=null){
        $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article')->setArticleValide($id);
        $articles = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article')->getAllArticlesAdmin();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($articles, $this->get('request')->query->get('page', 1), 5);
        $categories = $this->getDoctrine()->getManager()->getRepository('SHARINECategorieBundle:Categorie')->getAllCategories();
        return $this->render('SHARINEUserBundle:Home:accueil.html.twig', array(
            'categorie' => $categories,
            'article' => $articles,
            'pagination' => $pagination
        ));
    }

    public function refuserPublicationAction(){
        $raison = $this->get('request')->get('raison');
        $titre = $this->get('request')->get('titre');
//        $image_id = $this->get('request')->get('img');
        $id = $this->get('request')->get('id');
        $user = $this->getDoctrine()->getManager()->getRepository('SHARINEUserBundle:User')->getUserById($this->get('request')->get('user'));
        $message = \Swift_Message::newInstance()
            ->setSubject('Publication refusée')
            ->setFrom('Sharine@gmail.com')
            ->setTo($user[0]['email'])
            ->setBody($this->renderView('SHARINEUserBundle:Mail:publicationRefuser.txt.twig', array('user' => $user[0]['username'],
                                                                                                     'raison' => $raison,
                                                                                                     'titre' => $titre)))
        ;
        $this->get('mailer')->send($message);
        $art = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($art);
        $em->flush();

        $articles = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article')->getAllArticlesAdmin();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($articles, $this->get('request')->query->get('page', 1), 5);
        $categories = $this->getDoctrine()->getManager()->getRepository('SHARINECategorieBundle:Categorie')->getAllCategories();
        return $this->render('SHARINEUserBundle:Home:accueil.html.twig', array(
            'categorie' => $categories,
            'article' => $articles,
            'pagination' => $pagination
        ));
    }

    public function deleteCommentaireAction(Request $request){
        $idCommentaire = $this->getRequest()->get('idComm');
        $Commentaire = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Commentaire')->find($idCommentaire);
        $em = $this->getDoctrine()->getManager();
        $em->remove($Commentaire);
        $em->flush();

        return new Response(0);
    }

}
