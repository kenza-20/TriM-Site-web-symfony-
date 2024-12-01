<?php

namespace App\Controller;

use App\Entity\analyse;
use App\Entity\lab;
use App\Entity\chefLab;
use App\Entity\ordonnance;
use App\Form\AnalyseType;
use App\Form\ChefLabType;
use App\Form\OrdonnanceType;
use App\Repository\AnalyseRepository;
use App\Repository\ChefLabRepository;
use App\Repository\LabRepository;
use App\Repository\OrdonnanceRepository;
use App\Form\LabType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ChefLabController extends AbstractController
{
    #[Route('/cheflab', name: 'chef_lab')]
    public function index1(): Response
    {
        return $this->render('chef_lab/index.html.twig', [
            'controller_name' => 'ChefLabController',
        ]);
    }

    #[Route('/cheflab/labo/addLab/{id}', name:'add_lab')]
    public function createLab($id, Request $request, chefLabRepository $repo): Response
    {
        $cheflab = $repo->find($id);
        if ($cheflab->getIdLab() !== null) {
            // Afficher un message d'erreur
            $this->addFlash('error', 'Vous ne pouvez pas ajouter un laboratoire car vous en possédez déjà un.');
            // Rediriger l'utilisateur vers une autre page par exemple
            return $this->redirectToRoute('list_lab', ['id' => 1]);
        }
        $lab = new lab();
        $form = $this->createForm(LabType::class, $lab);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Les données du formulaire sont valides, vous pouvez les sauvegarder dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lab);
            $cheflab->setIdLab($lab);
            $entityManager->flush();
            return $this->redirectToRoute('list_lab', ['id' => 1]);
        }

        return $this->render('chef_lab/addLab.html.twig', ['form' => $form->createView(),]);
    }


    #[Route('/cheflab/labo/editLab/{id}', name:'edit_lab')]
    public function editLab($id, Request $request, EntityManagerInterface $entityManager)
    {
        // Récupérer l'auteur à partir de l'ID
        $lab = $entityManager->getRepository(lab::class)->find($id);

        if (!$lab) {
            throw $this->createNotFoundException('Lab non trouvé');
        }

        // Créer le formulaire de modification de l'auteur en utilisant l'entité récupérée
        $form = $this->createForm(LabType::class, $lab);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications dans la base de données
            $entityManager->flush();

            // Rediriger l'utilisateur vers une autre page (par exemple, la liste des auteurs)
            return $this->redirectToRoute('list_lab', ['id' => 1]);
        }

        return $this->render('chef_lab/editLab.html.twig', [
            'form' => $form->createView(),
            'lab' => $lab, // Passer l'entité Author pour afficher les informations actuelles
        ]);
    }

    #[Route('/delete/{id}', name:'delete_lab')]
    public function deleteLab($id, LabRepository $repo, ManagerRegistry $manager, ChefLabRepository $chefLabRepo)
    {
        $lab =$repo->find($id);
        $en=$manager->getManager();
        $en->remove($lab);
        $en->flush();

        // Rediriger l'utilisateur vers une autre page (par exemple, la liste des auteurs)
        return $this->redirectToRoute('list_lab',['id' => 1]);
    }

    #[Route('/cheflab/labo/editOrd/{id}', name:'edit_ord')]
    public function editOrd($id, Request $request, EntityManagerInterface $entityManager)
    {
        // Récupérer l'auteur à partir de l'ID
        $ord = $entityManager->getRepository(ordonnance::class)->find($id);

        if (!$ord) {
            throw $this->createNotFoundException('Ordonnance non trouvé');
        }

        // Créer le formulaire de modification de l'auteur en utilisant l'entité récupérée
        $form = $this->createForm(OrdonnanceType::class, $ord);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications dans la base de données
            $entityManager->flush();

            // Rediriger l'utilisateur vers une autre page (par exemple, la liste des auteurs)
            return $this->redirectToRoute('list_lab');
        }

        return $this->render('chef_lab/editOrd.html.twig', [
            'form' => $form->createView(),
            'ord' => $ord, // Passer l'entité Author pour afficher les informations actuelles
        ]);
    }

    //*************************************************************************************************************
    //*************************************************************************************************************

    #[Route('/cheflab/labo/addanalyse/{id}', name:'add_analyse')]
    public function createAnalyse($id, Request $request, EntityManagerInterface $entityManager, LabRepository $labRepository)
    {
        $lab = $labRepository->find($id);
        $analyse = new analyse();

        $form = $this->createForm(AnalyseType::class, $analyse);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Les données du formulaire sont valides, vous pouvez les sauvegarder dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($analyse);
            $analyse->setIdLab($lab);
            $entityManager->flush();
            return $this->redirectToRoute('list_lab', ['id' => 1]);
        }

        return $this->render('chef_lab/addAnalyse.html.twig', ['form' => $form->createView(),]);
    }

    #[Route('/cheflab/labo/editanalyse/{id}', name:'edit_analyse')]
    public function editanalyse($id, Request $request, EntityManagerInterface $entityManager)
    {
        // Récupérer l'auteur à partir de l'ID
        $analyse = $entityManager->getRepository(analyse::class)->find($id);

        if (!$analyse) {
            throw $this->createNotFoundException('analyse non trouvé');
        }

        // Créer le formulaire de modification de l'auteur en utilisant l'entité récupérée
        $form = $this->createForm(analyseType::class, $analyse);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications dans la base de données
            $entityManager->flush();

            // Rediriger l'utilisateur vers une autre page (par exemple, la liste des auteurs)
            return $this->redirectToRoute('list_lab', ['id' => 1]);
        }

        return $this->render('chef_lab/editanalyse.html.twig', [
            'form' => $form->createView(),
            'analyse' => $analyse, // Passer l'entité Author pour afficher les informations actuelles
        ]);
    }

    #[Route('/deleteanalyse/{id}', name:'delete_analyse')]
    public function deleteanalyse($id, AnalyseRepository $analyrepo, ManagerRegistry $manager, ChefLabRepository $chefLabRepo): Response
    {
        $analyse = $analyrepo->find($id);

        if (!$analyse) {
            // Gérer le cas où l'analyse avec l'ID spécifié n'existe pas
            $this->addFlash('error', 'L\'analyse que vous essayez de supprimer n\'existe pas.');
            return $this->redirectToRoute('list_lab',['id' => 1]);
        }

        $en = $manager->getManager();
        $en->remove($analyse);
        $en->flush();

        // Rediriger l'utilisateur vers une autre page (par exemple, la liste des analyses)
        return $this->redirectToRoute('list_lab',['id' => 1]);
    }

    //******************************************************************************************************************
    #[Route('/cheflab/labo/{id}', name: 'list_lab')]
    public function list($id,cheflabRepository $repo,LabRepository $labRepo, AnalyseRepository $anRepo): Response
    {
        $hasLab = false;
        $chefLab = $repo->find($id);
        if ($chefLab->getIdLab() !== null) {
            $hasLab = true;
        }
        $idLab = $chefLab->getIdlab();
        $labs = $labRepo->findBy(['id' => $idLab]);
        $analyses = $anRepo->findBy(['idLab' => $idLab]);
        return $this->render('chef_lab/labo.html.twig', [
            'Labs' => $labs,
            'analyses' => $analyses,
            'hasLab' => $hasLab,
        ]);
    }


    //******************************************************************************************************************
    #[Route('/cheflab/static', name: 'stat_lab')]
    public function stat(): Response
    {
        return $this->render('chef_lab/static.html.twig', [
            'controller_name' => 'ChefLabController',
        ]);
    }


    //*********************************Kenza****************************************************************************

    #[Route('/cheflab/add', name: 'chef_add')]
    public function create(Request $request):Response
    {
        $chef = new chefLab();
        $form = $this->createForm(ChefLabType::class, $chef);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Les données du formulaire sont valides, vous pouvez les sauvegarder dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chef);
            $entityManager->flush();

            $this->addFlash('success', 'le compte a été enregistré avec succès.');

            // Redirigez l'utilisateur vers une autre page (par exemple, une liste d'auteurs)
            return $this->redirectToRoute('app_home');
        }
        return $this->render('dash/chef_inscri.html.twig', [
            'form' => $form->createView(),
        ]);
    }




}
