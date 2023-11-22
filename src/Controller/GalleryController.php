<?php

namespace App\Controller;

use App\Entity\Gallery;
use App\Form\GalleryType;
use App\Message\GeneratePdfMessage;
use App\Repository\GalleryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gallery', name: "gallery_")]
class GalleryController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(GalleryRepository $galleryRepository): Response
    {
        //fetch all entities
        $gallery = $galleryRepository->findAll();

        // Check if the PDF files exist
        foreach ($gallery as $item) {
            $filesystem = new Filesystem();
            $filePath = './pdf/' . $item->getId() . '.pdf';

            //check if file exists in public folder
            if ($filesystem->exists($filePath)) {
                $item->pdfFilePath = 'pdf/' . $item->getId() . '.pdf';
                $item->pdfExists = file_exists($item->pdfFilePath);
            }
        }
        return $this->render('gallery/index.html.twig', [
            'gallery_list' => $gallery,
        ]);
    }

    #[Route('/create', name: 'create_gallery', methods: ['GET', 'POST'])]
    public function createGallery(Request $request, EntityManagerInterface $entityManager, MessageBusInterface $bus): Response
    {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->getData()->getImages() as $image) {
                $entityManager->persist($image);
                $gallery->addImage($image);
            }
            $entityManager->persist($gallery);
            $entityManager->flush();

            //dispatch message
            $bus->dispatch(new GeneratePdfMessage($gallery->getId()));

            return $this->redirectToRoute('gallery_list');
        }

        return $this->render('gallery/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Gallery $gallery): Response
    {
        return $this->render('gallery/show.html.twig', [
            'gallery' => $gallery,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_gallery', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, Gallery $gallery, MessageBusInterface $bus): Response
    {
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->getData()->getImages() as $image) {
                $entityManager->persist($image);
                $gallery->addImage($image);
            }
            $entityManager->persist($gallery);
            $entityManager->flush();

            //dispatch message
            $bus->dispatch(new GeneratePdfMessage($gallery->getId()));

            return $this->redirectToRoute('gallery_show', ['id' => $gallery->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gallery/edit.html.twig', [
            'gallery' => $gallery,
            'form' => $form,
        ]);
    }
}
