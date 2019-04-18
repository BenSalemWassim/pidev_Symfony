<?php

namespace ForumBundle\Repository;

use ForumBundle\Entity\Reponse;

/**
 * ReponseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReponseRepository extends \Doctrine\ORM\EntityRepository
{

    public function  findByQuestion($q){

        $query= $this->getEntityManager()
            ->createQuery("SELECT m FROM ForumBundle:Reponse m WHERE m.question=:ques ORDER BY m.date DESC")

            ->setParameter('ques',$q);
        return $query->getResult();

    }
    public function  derR($q){

        $query= $this->getEntityManager()
            ->createQuery("SELECT m FROM ForumBundle:Reponse m WHERE m.question=:ques ORDER BY m.date DESC")

            ->setParameter('ques',$q);
        $re = new Reponse();
$re=$query->getResult();
       if(isset($re[0])) {
            return $re[0] ;
        }else
       {
           return false ;
       }


    }
    public function getNb($v) {

        return $this->createQueryBuilder('r')

            ->select('COUNT(r)')
            ->where('r.question =:q')
             ->setParameter('q',$v)

            ->getQuery()

            ->getSingleScalarResult();

    }
}
