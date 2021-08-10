<?php

namespace App\Form;

use App\Entity\Etablissement;
use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('type')
            ->add('type', ChoiceType::class, [
                'choices' => $this->getChoice()
            ])
            ->add('ville', EntityType::class , [
                'class'=> Ville::class,
                'choice_label'=> 'nom',
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etablissement::class,
        ]);
    }

    public function getChoice()
    {
        $choices = ville::TT;
        $output = [];
        foreach($choices as $k => $v)
        {
            $output[$v]= $k;
        }
        return $output; 
    }
}
