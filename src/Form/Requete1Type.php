<?php

namespace App\Form;

use App\Entity\Requete;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Requete1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('etat', ChoiceType::class, [
            //     'choices' => $this->getChoice()
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Requete::class,
        ]);
    }

    public function getChoice()
    {
        $choices = Requete::ETAT;
        $output = [];
        foreach($choices as $k => $v)
        {
            $output[$v]= $k;
        }
        return $output; 
    }
}
