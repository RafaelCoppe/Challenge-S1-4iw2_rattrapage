<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // ->add('search', TextType::class, [
        //     'required' => false,
        //     'attr' => [
        //         'class' => 'w-full border-none bg-transparent px-4 py-1 text-gray-400 outline-none focus:outline-none',
        //         'placeholder' => 'Search...',
        //     ],
        // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
