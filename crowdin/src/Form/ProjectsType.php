<?php

namespace App\Form;

use App\Entity\Language;
use App\Entity\Projects;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', null, [
            'label' => 'Project name',
            'attr' => ['class' => 'form-control my-3', 'placeholder' => 'Enter a name for the project ...']
        ])

            ->add('langueOrigine', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'language',
                'multiple' => false,
                'label' => 'Select original language',
                'attr' => ['class' => 'my-3 form-control', 'placeholder' => 'Select the original language ...']
            ])
        ;
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}
