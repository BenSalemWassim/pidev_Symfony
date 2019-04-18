<?php

namespace ForumBundle\Controller;
use ForumBundle\Entity\Question;

use ForumBundle\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse ;
class ForumController extends Controller
{

    public function afficherforumAction(Request $request)
    {



        $res= array();
        $rr[0]= ['c'=>"Developpement Web"];
        $rr[1]= ['c'=>"Développement Mobile"];
        $rr[2]= ['c'=>"Design"];
        $rr[3]= ['c'=>"Marketing"];
        $rr[4]= ['c'=>"Systèmes dexploitation"];
        $rr[5]= ['c'=>"Reseaux"];
        $rr[6]= ['c'=>"Matériel & logiciels"];
        $rr[7]= ['c'=>"Jeux vidéo"];

        for ($i = 0; $i < 8; $i++) {
            $nb= $this->getDoctrine()->getManager()->getRepository(Question::class)->getNb( array_values($rr[$i]));

            $der= $this->getDoctrine()->getManager()->getRepository(Question::class)->derR(array_values($rr[$i]));

            $res[$i]=[


                'categorie'=>$rr[$i],
                'nr'=> $nb,
                'der'=>$der
            ];
        }
        $question = new Question ();
        $form= $this->createForm(QuestionType::class,$question);
        $form->handleRequest($request);












        if ($form->isSubmitted())
        { $em= $this->getDoctrine()->getManager();


            $writer= $this->getDoctrine()->getRepository(User::class)->find($this->getUser());
        $question->setWriter($writer);
            $em->persist($question);
            $em->flush();
   return $this->redirectToRoute('affiche',array('id'=>$question->getId())) ;
          //  return $this->render('@Forum/Question/affiche.html.twig', array( 'id' => $question->getId() ));
        }

        return $this->render('@Forum/Default/index.html.twig',
            array('form'=> $form->createView(),'cat' =>$res)
        );
    }
}
