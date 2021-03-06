<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


use App\Form\ContactType;
use App\Form\LivredorType;
use App\Form\UtilisateurType;


use App\Entity\Contact;
use App\Entity\Livredor;
use App\Entity\Utilisateur;


class ListeController extends AbstractController
{
    #[Route('/liste-contact', name: 'liste-contact')]
    public function listeContact(Request $request): Response
    {
        $doctrine = $this->getDoctrine();
        $em = $this->getDoctrine()->getManager();


        if($request->get('id') != null){
            $contact = $doctrine->getRepository(Contact::class)->find($request->get('id'));
            
            $em->remove($contact);
            $em->flush();
            return $this->redirectToRoute('liste-contact');
        }

        $repoContact = $this->getDoctrine()->getRepository(Contact::class);
        $contacts =$repoContact->findBy(array(),array('nom'=>'ASC'));

        return $this->render('liste/liste-contact.html.twig', ['contacts'=>$contacts]);
    }

       #[Route('/liste-livredor', name: 'liste-livredor')]
    public function listelivredor(Request $request): Response
    {
        $doctrine = $this->getDoctrine();
        $em = $this->getDoctrine()->getManager();

        if($request->get('id') != null){
            $livre = $doctrine->getRepository(Livredor::class)->find($request->get('id'));
            
            $em->remove($livre);
            $em->flush();
            return $this->redirectToRoute('liste-livredor');
        }

        $repolivredor = $this->getDoctrine()->getRepository(Livredor::class);
        $livres =$repolivredor->findBy(array(),array('nom'=>'ASC'));

        return $this->render('liste/liste-livredor.html.twig', ['livres'=>$livres]);
    }

    #[Route('/liste-utilisateur', name: 'liste-utilisateur')]
    public function listeUtilisateur(Request $request): Response
    {
        $doctrine = $this->getDoctrine();
        $em = $this->getDoctrine()->getManager();

        if($request->get('id') != null){
            $utilisateur = $doctrine->getRepository(Utilisateur::class)->find($request->get('id'));
            
            $em->remove($utilisateur);
            $em->flush();
            return $this->redirectToRoute('liste-utilisateur');
        }
        
        $repoContact = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateurs =$repoContact->findBy(array(),array('nom'=>'ASC'));

        return $this->render('liste/liste-utilisateur.html.twig', ['utilisateurs'=>$utilisateurs]);

    }
}
