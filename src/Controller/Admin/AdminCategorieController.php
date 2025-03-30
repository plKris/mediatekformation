<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategorieController extends AbstractController {
    
    #[Route('/admin/categories', name: 'admin.categorie')]
    public function index(CategorieRepository $categorieRepository): Response {
        $categories = $categorieRepository->findAll();
        return $this->render('admin/admin.categorie.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/admin/categorie/add', name: 'admin.categorie.add', methods: ['POST'])]
    public function add(Request $request, CategorieRepository $categorieRepository, EntityManagerInterface $em): Response {
        $name = trim($request->request->get('name'));
        
        if (!$name) {
            $this->addFlash('danger', 'Le nom de la catégorie est obligatoire.');
            return $this->redirectToRoute('admin.categorie');
        }
        
        $existingCategorie = $categorieRepository->findOneBy(['name' => $name]);
        if ($existingCategorie) {
            $this->addFlash('warning', 'Cette catégorie existe déjà.');
            return $this->redirectToRoute('admin.categorie');
        }
        
        $categorie = new Categorie();
        $categorie->setName($name);
        $em->persist($categorie);
        $em->flush();
        
        $this->addFlash('success', 'Catégorie ajoutée avec succès.');
        return $this->redirectToRoute('admin.categorie');
    }

    #[Route('/admin/categorie/delete/{id}', name: 'admin.categorie.delete')]
    public function delete(int $id, CategorieRepository $categorieRepository): Response {
    $entity = $categorieRepository->find($id);

    if (!$entity) {
        $this->addFlash('danger', 'Catégorie introuvable.');
        return $this->redirectToRoute('admin.categorie');
    }
    
    if ($entity->getFormations()->count() > 0) {
        $this->addFlash('warning', 'Impossible de supprimer cette catégorie car elle est rattachée à des formations.');
        return $this->redirectToRoute('admin.categorie');
    }

    $categorieRepository->remove($entity);
    $this->addFlash('success', 'Catégorie supprimée avec succès.');

    return $this->redirectToRoute('admin.categorie');
}
}
