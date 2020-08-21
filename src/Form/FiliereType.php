<?php

namespace App\Form;

use App\Entity\Filiere;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiliereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class,['attr'=>['class'=>"form-control", 'autocomplete'=>"off"]])
            //->add('slug')
            ->add('institut', EntityType::class,[
                'attr'=>['class'=>'form-control rubrique-select'],
                'class'=> 'App\Entity\Institut',
                'query_builder' => function(EntityRepository $er){
                    return $er->liste();
                },
                'choice_label' => 'sigle',
                'label' => 'Institut',
                'required'=>true,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filiere::class,
        ]);
    }
}
