<?php

namespace App\Controller;

use App\Entity\maladie;
use App\Form\MaladieType;
use App\Repository\MaladieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaladieController extends AbstractController
{
    #[Route('/maladies', name: 'maladies_list')]
    public function listMaladies (
        MaladieRepository $maladieRepository
    ): Response
    {
        $mal=$maladieRepository->findAll();
        return $this->render('maladie/listmaladies.html.twig', [
            'maladies' => $mal,
        ]);
    }

    #[Route('/addMaladie', name: 'add_maladie')]
    public function createMaladie(Request $request)
    {
        $maladie = new maladie();
        $form = $this->createForm(MaladieType::class, $maladie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($maladie);
            $entityManager->flush();

            // Redirect to a success page or any other desired action
            return $this->redirectToRoute('maladies_list');
        }

        return $this->render('maladie/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/editMaladie/{id}', name: 'edit_maladie')]
    public function editMaladie(
        Request $request,
        EntityManagerInterface $entityManager,
        maladie $maladie
    ): Response {
        $form = $this->createForm(MaladieType::class, $maladie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('maladies_list');
        }

        return $this->render('maladie/editMal.html.twig', [
            'form' => $form->createView(),
            'mal' => $maladie,
        ]);
    }

    #[Route('/maladie/delete/{id}',name: 'delete_maladie')]
    public function deleteMaladie($id,MaladieRepository $maladieRepository,
                                  EntityManagerInterface $entityManager):Response {
        $mal = $maladieRepository->find($id);
        $entityManager->remove($mal);
        $entityManager->flush();
        return $this->redirectToRoute('maladies_list');
    }
}
