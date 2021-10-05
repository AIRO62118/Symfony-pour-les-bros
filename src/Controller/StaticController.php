<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Form\ContactType;
use App\Form\LivredorType;
use App\Form\InscriptionType;
use App\Entity\Contact;
use App\Entity\Livredor;
use App\Entity\Utilisateur;


class StaticController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    public function accueil(): Response
    {
        return $this->render('static/accueil.html.twig', []);
    }
/*
     #[Route('/contact', name: 'contact')]
     public function contact(Request $request, \Swift_Mailer $mailer): Response
     {
         $form = $this->createForm(ContactType::class);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()&&$form->isValid()){
                $nom = $form->get('nom')->getData();
                $sujet = $form->get('sujet')->getData();
                $contenu = $form->get('message')->getData();
                $this->addFlash('notice','Message Envoyé');
                $message = (new \Swift_Message($form->get('sujet')->getData()))
                ->setFrom($form->get('email')->getData())
                ->setTo('fkarbowysio@gmail.com')
               // ->setBody($form->get("message")->getData());
                ->setBody($this->renderView('emails/contact-email.html.twig', array('nom'=>$nom, 'sujet'=>$sujet, 'message'=>$contenu)), 'text/html');
                $mailer->send($message);
                return $this->redirectToRoute('contact');
            }
        }
        


         return $this->render('static/contact.html.twig', ['form' => $form->createView()]);
     }
*/


 #[Route('/contact', name: 'contact')]
 public function contact(Request $request, \Swift_Mailer $mailer): Response
 {
     $contact=new Contact();
     $form = $this->createForm(ContactType::class, $contact);

    if($request->isMethod('POST')){
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            
            $this->addFlash('notice','Message Envoyé'.$contact->getNom());
            $message = (new \Swift_Message($contact->getSujet()))
            ->setFrom($contact->getEmail())
            ->setTo('fkarbowysio@gmail.com')
           // ->setBody($form->get("message")->getData());
            ->setBody($this->renderView('emails/contact-email.html.twig', array('nom'=>$contact->getNom(),'sujet'=>$contact->getSujet(),'message'=>$contact->getMessage())), 'text/html');
            $mailer->send($message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('contact');
        }
    }
    return $this->render('static/contact.html.twig', ['form' => $form->createView()]);

}

 #[Route('/livredor', name: 'livredor')]
 public function livredor(Request $request): Response
 {
    $livredor=new Livredor();
    $form = $this->createForm(LivredorType::class, $livredor);

    if($request->isMethod('POST')){
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $this->addFlash('notice','Message Envoyé'.$livredor->getNom());


            $em = $this->getDoctrine()->getManager();
            $em->persist($livredor);
            $em->flush();

            return $this->redirectToRoute('livredor');
        }
    }

     return $this->render('static/livredor.html.twig', ['form' => $form->createView()]);
 }
 

     #[Route('/mentions', name: 'mentions')]
     public function mentions(): Response
     {
         return $this->render('static/mentions.html.twig', []);
     }

     #[Route('/apropos', name: 'apropos')]
     public function apropos(): Response
     {
         return $this->render('static/apropos.html.twig', []);
     }



         


#[Route('/inscription', name: 'inscription')]
public function inscription(Request $request): Response
{
    $inscription=new Utilisateur();
    $form = $this->createForm(InscriptionType::class, $inscription);

    if($request->isMethod('POST')){
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $this->addFlash('notice','Inscription réussie');


            $em = $this->getDoctrine()->getManager();
            $em->persist($inscription);
            $em->flush();

            return $this->redirectToRoute('inscription');
        }
    }

     return $this->render('static/inscription.html.twig', ['form' => $form->createView()]);
 }
}