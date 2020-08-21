<?php

namespace App\Form;

use App\Entity\Institut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstitutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sigle', TextType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"]])
            ->add('denomination', TextType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Institut::class,
        ]);
    }
}
