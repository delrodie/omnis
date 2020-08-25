<?php

namespace App\Form;

use App\Entity\Inscription;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('reference')
            ->add('nom', TextType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"]])
            ->add('prenoms', TextType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"]])
            ->add('dateNaissance', TextType::class,['attr'=>['class'=>'form-control datetimepicker', 'autocomplete'=>"off"]])
            ->add('lieuNaissance', TextType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"]])
            ->add('contact', TextType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"]])
            ->add('correspondant', TextType::class,['attr'=>['class'=>'form-control', 'autocomplete'=>"off"]])
            ->add('niveauEtude', ChoiceType::class,[
                'attr'=>['class'=>"form-control select"],
                'choices'=>[
                    'BAC'=> "BAC",
                    'BAC +1' => "BAC +1",
                    'BAC +2' => "BAC +2",
                    'BAC +3' => "BAC +3",
                    'BAC +4' => "BAC +4",
                    'BAC +5' => "BAC +5",
                ]
            ])
            ->add('dernierDiplome', ChoiceType::class,[
                'attr'=>['class'=>"form-control select"],
                'choices'=>[
                    'Baccalaurat'=> "BAC",
                    'BTS'=> "BTS",
                    'Licence 1' => "LP 1",
                    'Licence 2' => "LP 2",
                    'Licence 3' => "LP 3"
                ]
            ])
            ->add('baccalaureat', FileType::class,[
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
                            'application/pdf',
                            'application/x-pdf'
                        ],
                        'mimeTypesMessage' => "Votre fichier doit être de type image"
                    ])
                ],
                'attr'=>['class'=>"upload"]
            ])
            ->add('fileIdentite', FileType::class,[
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
            ->add('fileDiplome', FileType::class,[
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
                            'application/pdf',
                            'application/x-pdf'
                        ],
                        'mimeTypesMessage' => "Votre fichier doit être de type image ou pdf"
                    ])
                ],
                'attr'=>['class'=>"upload"]
            ])
            //->add('createdAt')
            //->add('annee')
            ->add('filiere', EntityType::class,[
                'attr'=>['class'=>'form-control select'],
                'class'=> 'App\Entity\Filiere',
                'query_builder' => function(EntityRepository $er){
                    return $er->liste();
                },
                'choice_label' => 'libelle',
                'label' => 'Filiere',
                'required'=>true,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
