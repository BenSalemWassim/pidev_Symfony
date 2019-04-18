<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Question;
use ForumBundle\Entity\Reponse;
use ForumBundle\Form\ReponseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UpdateReponseController extends Controller
{
    public function updateAction(Request $request)
    {
        $idq = $request->attributes->get('idq');

        $id = $request->attributes->get('id');

        $question= $this->getDoctrine()->getRepository(Question::class)->find($idq);

        $reponse= $this->getDoctrine()->getRepository(Reponse::class)->find($id);


        $form= $this->createForm(ReponseType::class,$reponse);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reponse);
            $em->flush();

            return $this->redirectToRoute('affiche', array('id' => $idq)


            );


        }



        return $this->render('ForumBundle:UpdateReponse:update.html.twig', array( 'form'=> $form->createView(),
            // ...
        ));
    }

}
