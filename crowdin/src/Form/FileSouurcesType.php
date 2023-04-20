<?php

namespace App\Form;

use App\Entity\Language;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;

class FileSouurcesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Sources',FileType::class)
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
            // Configure your form options here
        ]);
    }
}
