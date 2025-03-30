<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFormationController extends AbstractController {

    private const FORMATIONS_TWIG = 'admin/admin.formations.html.twig';
    
    private $formationRepository;
    private $categorieRepository;

    // Injection des deux repositories dans le constructeur
    public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository = $categorieRepository;
    }

    #[Route('/admin/formations', name: 'admin.formations')]
    public function indexFormations(Request $request): Response {
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        $valeur = $request->get("recherche");
        $table = $request->get("table");
        if ($valeur) {
            $formations = $this->formationRepository->findByContainValue('title', $valeur, $table);
        }
        return $this->render(self::FORMATIONS_TWIG, [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
                ]);
    }

     #[Route('/admin/formations/tri/{champ}/{ordre}/{table}', name: 'admin.formations.sort')]
    public function sort($champ, $ordre, $table = ""): Response {
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::FORMATIONS_TWIG, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    // Route pour rechercher des formations selon un critère (title, playlist, category)
    #[Route('/admin/formations/recherche/{champ}/{table}', name: 'admin.formations.findallcontain')]
    public function findAllContain($champ, Request $request, $table = ""): Response {
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::FORMATIONS_TWIG, [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }

    #[Route('/formations/formation/{id}', name: 'formations.showone')]
    public function showOne($id): Response{
        $formation = $this->formationRepository->find($id);
        return $this->render(self::FORMATION_TWIG, [
            'formation' => $formation
        ]);        
    }   

    #[Route('/admin/formations/add', name: 'admin.formations.add')]
    public function add(Request $request, EntityManagerInterface $em): Response {
    $formation = new Formation();
    $form = $this->createForm(FormationType::class, $formation);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($formation);
        $em->flush();

        $this->addFlash('success', 'Formation ajoutée avec succès.');
        return $this->redirectToRoute('admin.formations');
    }

    return $this->render('admin/add_formation.html.twig', [
        'form' => $form->createView(),
    ]);
}

    #[Route('/admin/formations/edit/{id}', name: 'admin.formations.edit')]
    public function edit(int $id, FormationRepository $formationRepository, Request $request, EntityManagerInterface $em): Response {
        
    $formation = $formationRepository->find($id);

    if (!$formation) {
        $this->addFlash('danger', 'Formation introuvable.');
        return $this->redirectToRoute('admin.formations');
    }

    // Création du formulaire avec les données existantes
    $form = $this->createForm(FormationType::class, $formation);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        $this->addFlash('success', 'Formation mise à jour avec succès.');
        return $this->redirectToRoute('admin.formations');
    }

    return $this->render('admin/edit_formation.html.twig', [
        'form' => $form->createView(),
        'formation' => $formation,
    ]);
}

    #[Route('/admin/formations/delete/{id}', name: 'admin.formations.delete')]
    public function deleteFormation(Formation $formation, EntityManagerInterface $em): Response {
        $em->remove($formation);
        $em->flush();
        return $this->redirectToRoute('admin.formations');
    }
}

