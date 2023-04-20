<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Sources;
use App\Entity\Projects;
use App\Form\ProjectsType;
use App\Repository\SourcesRepository;
use App\Repository\LanguageRepository;
use App\Repository\ProjectsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



#[Route('/projects')]
class ProjectsController extends AbstractController
{
    #[Route('/{id}/csv', name: 'app_source_csv', methods: ['POST','GET'])]
public function readCsvFile(int $id,Request $request, SourcesRepository $sourcesRepository, ProjectsRepository $projectsRepository)
{
    $form = $this->createFormBuilder();
    $form->add('Sources',FileType::class)
    ->add('langue_origin',LanguageType::class)
    ->add('langue_traduction',LanguageType::class);
    $form = $form->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $file = $form->get('Sources')->getData();
        $contents = file_get_contents($file);
        // Convertir le contenu en tableau
        $data = str_getcsv($contents, "\n"); // Lire les lignes du CSV
        $csvData = array_map('str_getcsv', $data, array_fill(0, count($data), ';')); // Convertir les lignes en tableau associatif
        // Vérifier si le fichier CSV est vide
        if (count($csvData) <= 1) {
            throw new \Exception('Le fichier CSV est vide.');
        }
        // Récupérer les informations du fichier CSV
        $headers = $csvData[0]; // Première ligne = les en-têtes
        $rows = array_slice($csvData, 1); // Les lignes suivantes = les données
        //dd($headers);
        // Parcourir les données du fichier CSV
        foreach ($rows as $row) {
            $row = array_map('trim', $row); // Supprimer les espaces autour des données
            // Récupérer la clé et la valeur
            $key = $row[0]; // Première colonne = clé
            $value =$row[1]; // Deuxième colonne = valeur
            // Créer une entité pour enregistrer en base de données
            $source = new Sources(); // Remplacez "VotreEntity" par le nom de votre entité
            // Affecter les valeurs à l'entité
            $source->setTitre($key); // Mettre la clé dans la propriété correspondante de votre entité
            $source->setContenu($value); // Mettre la valeur dans la propriété correspondante de votre entité
            $source->setLangueOrigin($form->get('langue_origin')->getData()); // Mettre la valeur dans la propriété correspondante de votre entité
            $source->setLangueTraduction($form->get('langue_traduction')->getData()); // Mettre la valeur dans la propriété correspondante de votre entité
            $source->setIdProject($projectsRepository->find($id));
            // Enregistrer l'entité en base de données
            $sourcesRepository->save($source, true);
        }

    }
    return $this->renderForm('projects/test.html.twig', [
        'projects' => 'rr',
        'form' => $form,
    ]);
            
    
}

    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/', name: 'app_projects_index', methods: ['GET'])]
    public function index(ProjectsRepository $projectsRepository, ManagerRegistry $doctrine): Response
    {
        $this->doctrine = $doctrine;
        $projects = $doctrine->getRepository(Projects::class)->findAll();
        
        return $this->render('projects/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/new', name: 'app_projects_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProjectsRepository $projectsRepository,LanguageRepository $languageRepository,Security $security): Response
    {
        $project = new Projects();
        $form = $this->createForm(ProjectsType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->setUserId($security->getUser());
            $projectsRepository->save($project, true);

            return $this->redirectToRoute('app_projects_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('projects/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_projects_show', methods: ['GET'])]
    public function show(Projects $project): Response
    {
        
        return $this->render('projects/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_projects_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projects $project, ProjectsRepository $projectsRepository): Response
    {
        $form = $this->createForm(ProjectsType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projectsRepository->save($project, true);

            return $this->redirectToRoute('app_projects_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('projects/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_projects_delete', methods: ['POST'])]
    public function delete(Request $request, Projects $project, ProjectsRepository $projectsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $projectsRepository->remove($project, true);
        }

        return $this->redirectToRoute('app_projects_index', [], Response::HTTP_SEE_OTHER);
    }




}
