<?php

namespace App\Form;
use App\Classe\Search;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        # Ajout d'un champ de saisie de texte pour la chaîne de recherche
        $builder
            ->add('string', TextType::class, [
                'label' => 'Rechercher',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre recherche ...',
                    'class' => 'form-control-sm',
                ],
            ])
            # Ajout d'une liste déroulante de catégories à cocher
            ->add('categories', EntitiesType::class, [
                'label' => false,
                'required' => false,
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
            ])
            # Ajout d'un bouton de soumission
            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer',
                'attr' => [
                    'class' => 'btn-info',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        # Définition des valeurs par défaut pour le formulaire
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}

// Ce code est une classe de formulaire pour un formulaire de recherche dans une application Symfony. Il étend la classe AbstractType et utilise les classes TextType, EntitiesType, SubmitType, Search et Category
