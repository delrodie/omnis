<?php

namespace App\Form;

use App\Entity\Test;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,['attr'=>['class'=>'form-control','autocomplete'=>"off"]])
            ->add('dateDebut',TextType::class,['attr'=>['class'=>'form-control datetimepicker','autocomplete'=>"off"]])
            ->add('dateFin',TextType::class,['attr'=>['class'=>'form-control datetimepicker','autocomplete'=>"off"]])
            ->add('lundi', CheckboxType::class,['required'=>false])
            ->add('mardi', CheckboxType::class,['required'=>false])
            ->add('mercredi', CheckboxType::class,['required'=>false])
            ->add('jeudi', CheckboxType::class,['required'=>false])
            ->add('vendredi', CheckboxType::class,['required'=>false])
            ->add('samedi', CheckboxType::class,['required'=>false])
            ->add('dimanche', CheckboxType::class,['required'=>false])
            ->add('annee', EntityType::class,[
                'attr'=>['class'=>'form-control select'],
                'class'=> 'App\Entity\Annee',
                'query_builder' => function(EntityRepository $er){
                    return $er->liste();
                },
                'choice_label' => 'libelle',
                'label' => 'Institut',
                'required'=>true,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }
}
