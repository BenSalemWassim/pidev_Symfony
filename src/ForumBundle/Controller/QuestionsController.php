<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Reponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ForumBundle\Entity\Question;
class QuestionsController extends Controller
{

    public function indexAction(Request $request)
    {
        $x=null ;
        $id = $request->attributes->get('id');
        $questions= $this->getDoctrine()->getRepository(Question::class)->findBy( array('categorie' => $id));
        $res= array();
        $nba = sizeof($questions);

        for ($i = 0; $i < $nba; $i++) {
            $nb= $this->getDoctrine()->getManager()->getRepository(Reponse::class)->getNb($questions[$i]);

                        $der= $this->getDoctrine()->getManager()->getRepository(Reponse::class)->derR($questions[$i]);

            $res[$i]=[


                'question'=>$questions[$i],
                'nr'=> $nb,
                 'der'=>$der
            ];

        }


        return $this->render('ForumBundle:Question:questions.html.twig', ['questions'=>  $res,'id'=>$id]);
    }

}
