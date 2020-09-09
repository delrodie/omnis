<?php

namespace App\Form;

use App\Entity\CompositionTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompositionTestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('date')
            //->add('ordre')
            ->add('resultat', ChoiceType::class,[
                'attr'=>['class'=>"form-control select"],
                'choices'=>[
                    'Admis(e)'=> "ADMIS(E)",
                    'Non admis(e)' => "NON ADMIS(E)",
                ]
            ])
            //->add('candidat')
            //->add('test')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompositionTest::class,
        ]);
    }
}
