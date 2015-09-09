<?php


namespace SHARINE\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurController extends Controller
{
    public function utilisateurGestionAction()
    {
        $users = $this->getDoctrine()->getManager()->getRepository('SHARINEUserBundle:User')->getNomEmail();
        $tabRoles = array();
        foreach($users as $user => $value){
            $tabRoles[$value['id']] = "";
            foreach($value['roles'] as $roles){
                if(isset($roles) and $roles != null and $roles != ""){
                    $tabRoles[$value['id']] = $roles;
                }
            }
        }

        $nbArticles = $this->getDoctrine()->getManager()->getRepository('SHARINEArticleBundle:Article');
        $tabResult = array();

        foreach($users as $user){
            $tabResult[$user['id']] = $nbArticles->getNbArticlesByUser($user['id']);
        }
        return $this->render('SHARINEUserBundle:Home:utilisateurGestion.html.twig', array(
            'user' => $users,
            'nbArticles' => $tabResult,
            'roles' => $tabRoles
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

    public function changerStatusUserAction(Request $request){
        $idUser = $this->getRequest()->get('user');
        $idStatus = $this->getRequest()->get('status');
        $user = $this->getDoctrine()->getManager()->getRepository('SHARINEUserBundle:User')->find($idUser);
        if($idStatus == "Admin"){
            $user->setRoles(array('ROLE_USER'));
        }else{
            $user->setRoles(array('ROLE_ADMIN'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return new Response(0);
    }

}