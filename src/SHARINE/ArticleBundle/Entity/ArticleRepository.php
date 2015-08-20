<?php

namespace SHARINE\ArticleBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    public function getAllArticles($categorie = null)
    {
        if(isset($categorie) and $categorie != null){
            return $this->_em->createQueryBuilder()
                ->select('a')
                ->from('SHARINEArticleBundle:Article' , 'a')
                ->join('a.categorie', 'i')
                ->Where('i.nom = :categorie')
                ->andWhere('a.is_active = 1')
                ->orderBy('a.id', 'DESC')
                ->setMaxResults( 100 )
                ->setParameter( 'categorie',$categorie)
                ->getQuery()
                ->getResult();
        }else {
            return $this->_em->createQueryBuilder()
                ->select('a')
                ->from('SHARINEArticleBundle:Article', 'a')
                ->join('a.categorie', 'i')
                ->Where('a.is_active = 1')
                ->orderBy('a.id', 'DESC')
                ->setMaxResults(100)
                ->getQuery()
                ->getResult();
        }
    }

    public function getArticlesByIdUser($id){
        return $this->_em->createQueryBuilder()
            ->select('a')
            ->from('SHARINEArticleBundle:Article' , 'a')
            ->join('a.user', 'i')
            ->Where('i.id = :id')
            ->orderBy('a.id', 'DESC')
            ->setParameter( 'id', $id )
            ->getQuery()
            ->getResult();
    }

    public function getArticlesByIdArticle($id){
        return $this->_em->createQueryBuilder()
            ->select('a')
            ->from('SHARINEArticleBundle:Article' , 'a')
            ->Where('a.id = :id')
            ->setParameter( 'id', $id )
            ->getQuery()
            ->getResult();
    }

    public function getAllArticlesAdmin(){
        return $this->_em->createQueryBuilder()
            ->select('a')
            ->from('SHARINEArticleBundle:Article', 'a')
            ->join('a.categorie', 'i')
            ->Where('a.is_active = 0')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }

    public function setArticleValide($id){
        $qb = $this->_em->createQueryBuilder();
        $q = $qb->update('SHARINEArticleBundle:Article', 'a')
            ->set('a.is_active', '1')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $p = $q->execute();
    }

    public function deletePublication($id){
        $qb = $this->_em->createQueryBuilder();
        $q = $qb->delete('SHARINEArticleBundle:Article', 'a')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $p = $q->execute();
    }

}
