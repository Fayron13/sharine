<?php


namespace SHARINE\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurController extends Controller
{
    public function utilisateurGestionAction()
    {
        $users = $this->getDoctrine()->getManager()->getRepository('SHARINEUserBundle:User')->getNomEmail();
        $nbArticles = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article');
        $tabResult = array();

        foreach($users as $user){
            $tabResult[$user['id']] = $nbArticles->getNbArticlesByUser($user['id']);
        }
        return $this->render('SHARINEUserBundle:Home:utilisateurGestion.html.twig', array(
            'user' => $users,
            'nbArticles' => $tabResult,
        ));
    }

    public function archiverUserAction($idUser){
        $archive = $this->get('request')->get('archive');
        $desarchive = $this->get('request')->get('desarchive');
        $user = $this->getDoctrine()->getManager()->getRepository('SHARINEUserBundle:User')->find($idUser);
        if($archive == 1){
            $user->setIsArchive(1);
        }

        if($desarchive == 1){
            $user->setIsArchive(0);
        }
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush($user);
        $users = $this->getDoctrine()->getManager()->getRepository('SHARINEUserBundle:User')->getNomEmail();
        $nbArticles = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article');
        $tabResult = array();

        foreach($users as $user){
            $tabResult[$user['id']] = $nbArticles->getNbArticlesByUser($user['id']);
        }
        return $this->render('SHARINEUserBundle:Home:utilisateurGestion.html.twig', array(
            'user' => $users,
            'nbArticles' => $tabResult,
        ));
    }

}