<?php

namespace App\Form;

use App\Entity\Scolarite;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScolariteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant', IntegerType::class,['attr'=>['class'=>"form-control", 'autocomplte'=>"off"]])
            ->add('classe', EntityType::class,[
                'attr'=>['class'=>'form-control rubrique-select'],
                'class'=> 'App\Entity\Classe',
                'query_builder' => function(EntityRepository $er){
                    return $er->liste();
                },
                'choice_label' => 'sigle',
                'label' => 'Niveau',
                'required'=>true,
                'multiple' => false
            ])
            ->add('filiere', EntityType::class,[
                'attr'=>['class'=>'form-control rubrique-select'],
                'class'=> 'App\Entity\Filiere',
                'query_builder' => function(EntityRepository $er){
                    return $er->liste();
                },
                'choice_label' => 'libelle',
                'label' => 'Filière',
                'required'=>true,
                'multiple' => false
            ])
            //->add('annee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Scolarite::class,
        ]);
    }
}
