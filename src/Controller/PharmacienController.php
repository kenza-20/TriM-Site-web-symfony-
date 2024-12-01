<?php

namespace App\Controller;

use App\Entity\pharmacie;
use App\Form\PharmacieType;
use App\Repository\PharmacieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PharmacienController extends AbstractController
{
    #[Route('/pharmacien', name: 'app_pharmacie')]
    public function list(PharmacieRepository $repo): Response
    {
        // Récupérer les données des pharmacies depuis la base de données
        $pharmacies = $repo->findAll();
        return $this->render('pharmacien/pharmacie.html.twig', [
            'pharmacies' => $pharmacies,
        ]);
    }

    #[Route('/pharmacien/ajouter', name: 'app_pharmacie_ajouter')]
    public function Add(Request $request): Response
    {
        $pharmacie = new Pharmacie();
        $form = $this->createForm(PharmacieType::class, $pharmacie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pharmacie);
            $entityManager->flush();
            return $this->redirectToRoute('app_pharmacie');
        }
        return $this->render("/pharmacien/ajoutPharmacie.html.twig", ['form' => $form->createView()]);
    }

    #[Route('/pharmacien/modifier/{id}', name: 'app_pharmacie_modifier')]
    public function edit(PharmacieRepository $repository, $id, Request $request)
    {
        $pharmacie = $repository->find($id);
        $form = $this->createForm(PharmacieType::class, $pharmacie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('app_pharmacie'); // Redirigez vers la route 'app_Affiche'
        }

        return $this->render("pharmacien/modifierPharmacie.html.twig", [ 'form' => $form->createView(),'pharmacies' => $pharmacie]);
    }

    #[Route('/pharmdelete/{id}', name:'delete_pharm')]
    public function deleteLab($id, PharmacieRepository $repo, ManagerRegistry $manager)
    {
        $pharmacie =$repo->find($id);
        $en=$manager->getManager();
        $en->remove($pharmacie);
        $en->flush();

        // Rediriger l'utilisateur vers une autre page (par exemple, la liste des auteurs)
        return $this->redirectToRoute('app_pharmacie');
    }


}
