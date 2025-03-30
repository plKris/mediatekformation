<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\Admin;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of PlaylistsController
 *
 * @author emds
 */
class AdminPlaylistController extends AbstractController {
    
    private const TEMPLATE_PLAYLISTS = 'admin/admin.playlists.html.twig';
    
    /**
     * 
     * @var PlaylistRepository
     */
    private $playlistRepository;
    
    /**
     * 
     * @var FormationRepository
     */
    private $formationRepository;
    
    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;    
    
    function __construct(PlaylistRepository $playlistRepository, 
            CategorieRepository $categorieRepository,
            FormationRepository $formationRespository) {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRespository;
    }
    
    /**
     * @Route("/playlists", name="playlists")
     * @return Response
     */
    #[Route('admin/playlists', name: 'admin.playlists')]
    public function index(): Response{
        $playlists = $this->playlistRepository->findAllOrderByName('ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::TEMPLATE_PLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }
    
    #[Route('/admin/playlists/add', name: 'admin.playlists.add')]
    public function addPlaylist(Request $request, EntityManagerInterface $em): Response {
            $playlist = new Playlist();
    $form = $this->createForm(PlaylistType::class, $playlist);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($playlist);
        $em->flush();
        return $this->redirectToRoute('admin.playlists');
    }

    return $this->render('admin/add_playlist.html.twig', [
        'form' => $form->createView()
    ]);
    }

    #[Route('/admin/playlists/edit/{id}', name: 'admin.playlists.edit')]
    public function editPlaylist(Playlist $playlist, Request $request, EntityManagerInterface $em): Response {
        $form = $this->createForm(PlaylistType::class, $playlist);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        return $this->redirectToRoute('admin.playlists');
    }
    return $this->render('admin/edit_playlist.html.twig', [
        'form' => $form->createView(),
        'playlist' => $playlist
    ]);
    }

    #[Route('/admin/playlists/delete/{id}', name: 'admin.playlists.delete')]
    public function deletePlaylist(Playlist $playlist, EntityManagerInterface $em): Response {
        $em->remove($playlist);
        $em->flush();
        return $this->redirectToRoute('admin.playlists');
    }

    #[Route('/playlists/tri/{champ}/{ordre}', name: 'admin.playlists.sort')]
    public function sort($champ, $ordre): Response{
        switch($champ){
            case "name":
                $playlists = $this->playlistRepository->findAllOrderByName($ordre);
                break;
             case "formations_count":
            $playlists = $this->playlistRepository->findAllOrderByNbFormations($ordre);
            break;
            default:
                $playlists = $this->playlistRepository->findAllOrderByName('ASC');
            break;
    }
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::TEMPLATE_PLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }          

    #[Route('/admin/playlists/recherche/{champ}/{table}', name: 'admin.playlists.findallcontain')]
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::TEMPLATE_PLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories,            
            'valeur' => $valeur,
            'table' => $table
        ]);
    }  

    #[Route('/playlists/playlist/{id}', name: 'playlists.showone')]
    public function showOne($id): Response{
        $playlist = $this->playlistRepository->find($id);
        $playlistCategories = $this->categorieRepository->findAllForOnePlaylist($id);
        $playlistFormations = $this->formationRepository->findAllForOnePlaylist($id);
        return $this->render(self::TEMPLATE_PLAYLIST, [
            'playlist' => $playlist,
            'playlistcategories' => $playlistCategories,
            'playlistformations' => $playlistFormations
        ]);        
    }  
    
}
