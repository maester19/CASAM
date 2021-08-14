<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Ville;
use App\Entity\Etablissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('niveau')
            ->add('filiere')
            ->add('noteVille')
            ->add('noteEta')
            ->add('ville', EntityType::class , [
                'class'=> Ville::class,
                'choice_label'=> 'nom',
                'multiple' => false
            ])
            ->add('etablissement', EntityType::class , [
                'class'=> Etablissement::class,
                'choice_label'=> 'nom',
                'multiple' => false
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
