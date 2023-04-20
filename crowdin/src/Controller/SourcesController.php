<?php

namespace App\Controller;

use App\Entity\Sources;
use App\Form\SourcesType;
use App\Repository\SourcesRepository;
use App\Repository\ProjectsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/sources')]
class SourcesController extends AbstractController
{
    
    #[Route('/show/{id}', name: 'app_sources_index', methods: ['GET'])]
    public function index(SourcesRepository $sourcesRepository,int $id,EntityManagerInterface $entityManager): Response
    {
        $sources = $entityManager
        ->getRepository(Sources::class)
        ->createQueryBuilder('d')
        ->where('d.idProject = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();

        return $this->render('sources/index.html.twig', [
            'sources' => $sources,
            'idProject' => $id
        ]);
    }

    #[Route('/{idProject}/new', name: 'app_sources_new', methods: ['GET', 'POST'])]
    public function new(int $idProject,Request $request, SourcesRepository $sourcesRepository, ProjectsRepository $projectsRepository): Response
    {
        $source = new Sources();
        $form = $this->createForm(SourcesType::class, $source);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $source->setIdProject($projectsRepository->find($idProject));
            $sourcesRepository->save($source, true);

            return $this->redirectToRoute('app_sources_index', ['id' => $idProject], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sources/new.html.twig', [
            'source' => $source,
            'form' => $form,
            'idProject' => $idProject
        ]);
    }
    #[Route('/{id}', name: 'app_sources_show', methods: ['GET'])]
    public function show(Sources $source): Response
    {
        return $this->render('sources/show.html.twig', [
            'source' => $source,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sources_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sources $source, SourcesRepository $sourcesRepository): Response
    {
        $form = $this->createForm(SourcesType::class, $source);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sourcesRepository->save($source, true);

            return $this->redirectToRoute('app_projects_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sources/edit.html.twig', [
            'source' => $source,
            'form' => $form,
        ]);
    }

    
}
