<?php

namespace ForumBundle\Controller;
use ForumBundle\Entity\Question;
use ForumBundle\Entity\Reponse;
use Symfony\Component\HttpFoundation\Request;
use ForumBundle\Form\ReponseType ;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\User;

class QuestionController extends Controller
{
    public function afficheAction(Request $request)
    {
        $id = $request->attributes->get('id');


        $question= $this->getDoctrine()->getRepository(Question::class)->find($id);
       // $repository = $this->getDoctrine()->getRepository(Reponse::class);

       // $reps=$repository->findBy(
       //     array('question' => $question));

         $em= $this->getDoctrine()->getManager();
         $reps=$em->getRepository("ForumBundle:Reponse") ->findByQuestion($question->getId());

 $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $reps, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );


        $rep = new Reponse() ;
        $form= $this->createForm(ReponseType::class,$rep);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        { $em= $this->getDoctrine()->getManager();
            $writer= $this->getDoctrine()->getRepository(User::class)->find($this->getUser()->getId());
              $rep->setWriter($writer);
              $rep->setQuestion($question);
            $em->persist($rep);

            $em->flush();
            $this->sendNotification(new Request(),$rep->getQuestion()->getWriter(),$this->getUser()->getUsername().' a repondu à votre question.');
            return $this->redirectToRoute('affiche',array('id'=>$question->getId())) ;
            //  return $this->render('@Forum/Question/affiche.html.twig', array( 'id' => $question->getId() ));
        }
        return $this->render('ForumBundle:Question:affiche.html.twig', array(
           'form'=> $form->createView(),
            'question'=>$question,
            'reps'=>$pagination
        ));
    }
    public function deleterAction(Request $request){
        $id = $request->attributes->get('id');
        $idq = $request->attributes->get('idq');

        $em= $this->getDoctrine()->getManager();
        $r= $this->getDoctrine()->getRepository(Reponse::class)->find($id);
$em->remove($r);
$em->flush();
return $this->redirectToRoute('affiche',['id'=>$id]);
    }
    public function deleteqAction(Request $request){
        $id = $request->attributes->get('id');

        $em= $this->getDoctrine()->getManager();
        $r= $this->getDoctrine()->getRepository(Question::class)->find($id);
        $em->remove($r);
        $em->flush();
        return $this->redirectToRoute('forum_homepage');
    }
    /**
     * @Route("/send-notification", name="send_notification")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendNotification(Request $request, $user,$txt)
    {
        $manager = $this->get('mgilet.notification');
        $notif = $manager->createNotification('Reponse');
        $notif->setMessage($txt);
        // or the one-line method :
        // $manager->createNotification('Notification subject','Some random text','http://google.fr');

        // you can add a notification to a list of entities
        // the third parameter ``$flush`` allows you to directly flush the entities
        $manager->addNotification(array($user), $notif, true);

        return $this->redirectToRoute('Home');
    }

}
