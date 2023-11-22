<?php

namespace App\Controller;

use App\Entity\Branch;
use App\Entity\Gallery;
use App\Form\GalleryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gallery', name: "gallery_")]
class GalleryController extends AbstractController
{
    #[Route('/gallery', name: 'list')]
    public function index(): Response
    {
        return $this->render('gallery/index.html.twig', [
            'controller_name' => 'GalleryController',
        ]);
    }
    #[Route('/create', name: 'create_gallery', methods: ['GET', 'POST'])]
    public function createGallery(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);

        $form->handleRequest($request);

        dump($gallery);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->getData()->getImages() as $image){
                $entityManager->persist($image);
                $gallery->addImage($image);
            }
            $entityManager->persist($gallery);
            $entityManager->flush();

            return $this->redirectToRoute('gallery_list');
        }

        return $this->render('gallery/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}', name: 'app_branch_show', methods: ['GET'])]
    public function show(Gallery $gallery): Response
    {
        return $this->render('gallery/show.html.twig', [
            'gallery' => $gallery,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_gallery', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_branch_show', ['id' => $gallery->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gallery/edit.html.twig', [
            'gallery' => $gallery,
            'form' => $form,
        ]);
    }
}
