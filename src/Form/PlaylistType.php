<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Form;

use App\Entity\Playlist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaylistType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la playlist'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de la playlist',
                'required' => false,  // Champ optionnel
            ])
            // Affichage des catégories associées à la playlist
            ->add('categoriesList', TextareaType::class, [
                'label' => 'Catégories associées',
                'mapped' => false, // Ne pas mapper avec l'entité
                'data' => implode(", ", $options['data']->getCategoriesPlaylist()->toArray()), // Liste des catégories
                'attr' => ['readonly' => true, 'rows' => 3] // Lecture seule
            ])
            // Affichage des formations associées à la playlist
            ->add('formationsList', TextareaType::class, [
                'label' => 'Formations associées',
                'mapped' => false, // Ne pas mapper avec l'entité
                'data' => implode("\n", $options['data']->getFormations()->map(fn($f) => $f->getTitle())->toArray()), // Liste des titres des formations
                'attr' => ['readonly' => true, 'rows' => 5] // Lecture seule
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Playlist::class,
        ]);
    }
}
