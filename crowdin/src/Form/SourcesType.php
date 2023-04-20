<?php

namespace App\Form;

use App\Entity\Sources;
use App\Entity\Language;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SourcesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'label' => 'Source Title',
                'attr' => ['class' => 'form-control my-3', 'placeholder' => 'Enter a title for the source ...']
            ])
            ->add('contenu', null, [
                'label' => 'Source content',
                'attr' => ['class' => 'form-control my-3', 'placeholder' => 'Enter the source content ...']
            ])
            ->add('langueOrigin', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'language',
                'multiple' => false,
                'label' => 'Select original language',
                'attr' => ['class' => 'my-3 form-control', 'placeholder' => 'Select the original language ...']
            ])
            ->add('langueTraduction', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'language',
                'multiple' => false,
                'label' => 'Select translate language',
                'attr' => ['class' => 'my-3 form-control', 'placeholder' => 'Select the translate language ...']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sources::class,
        ]);
    }
}
