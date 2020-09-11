<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('matricule')
            ->add('ancienMatricule', TextType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"],'required'=>false])
            ->add('nom', TextType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"]])
            ->add('prenoms', TextType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"]])
            ->add('dateNaiss', TextType::class,['attr'=>['class'=>'form-control datetimepicker', 'autocomplete'=>"off"]])
            ->add('lieuNaiss', TextType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"]])
            ->add('contact', TelType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"]])
            ->add('correspondant', TelType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"]])
            ->add('photo', FileType::class,[
                'mapped'=>false,
                'required' =>true,
                'constraints'=>[
                    new File([
                        'maxSize' => '100000k',
                        'mimeTypes' =>[
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => "Votre fichier doit être de type image"
                    ])
                ],
                'attr'=>['class'=>"upload"]
            ])
            //->add('slug')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
