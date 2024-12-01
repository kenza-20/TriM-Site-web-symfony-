<?php

namespace App\Controller;

use App\Entity\reclamation;
use App\Form\ReclamationType;
use App\Repository\PatientRepository;
use App\Repository\ReclamationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController
{

    #[Route('/patient/{id}', name:'app_reclamation2')]
    public function createReclamation($id,Request $request, PatientRepository $repo)
    {
        $patient = $repo->find($id);
        $rec= new reclamation();
        $form = $this->createForm(ReclamationType::class, $rec);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Les données du formulaire sont valides, vous pouvez les sauvegarder dans la base de données
            $rec->setDaterec(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rec);
            $rec->setIdPatients($patient);
            $entityManager->flush();

            $this->addFlash('success', 'L\'auteur a été enregistré avec succès.');

            // Redirigez l'utilisateur vers une autre page (par exemple, une liste d'auteurs)
            return $this->redirectToRoute('app_reclamation2', ['id' => 1]);
        }

        return $this->render('reclamation/addRec.html.twig', ['form' => $form->createView(),]);
    }

    #[Route('/reclamation', name: 'app_affiche_reclamation')]
    public function list(ReclamationRepository $repo): Response
    {
        $list=$repo->findAll();
        return $this->render('reclamation/reclamation.html.twig', [
            'reclamation' => $list,
        ]);
    }

    #[Route('/recdelete/{id}', name:'delete_rec')]
    public function delete_rec($id,ReclamationRepository $repo,ManagerRegistry $manager)
    {
        $rec=$repo->find($id);
        $em=$manager->getManager();
        $em->remove($rec);
        $em->flush();
        return $this->redirectToRoute('app_affiche_reclamation');
    }
    #[Route('/recshowO/{id}', name:'showA')]
    public function showO($id,ReclamationRepository $repo)
    {
        $reclamation=$repo->find($id);
        return $this->render('reclamation/showO.html.twig',['reclamation'=>$reclamation]);

    }
}
