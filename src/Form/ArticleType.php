<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Couleur;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->remove('image')
            ->add('imageFile', FileType::class, ['required' => false])
            ->add('description')
            ->add('prix')
            ->add('categorie', EntityType::class, ["class" => Categorie::class, 'placeholder' => 'Choisi une catégorie', 'required' => false])
            ->add('couleur', EntityType::class, ["class" => Couleur::class, 'placeholder' => 'Choisi une couleur', 'required' => false])
            ->add('active')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
