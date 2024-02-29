<?php

namespace App\Form;

use App\Entity\Agency;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'label_attr' => ['class' => 'block text-xl mb-3 font-medium text-gray-700 font-semibold'],
                'attr' => ['class' => 'mt-2 bg-transparent border-2 p-2 rounded-md w-full'],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'label_attr' => ['class' => 'block text-xl mb-3 font-medium text-gray-700 font-semibold'],
                'attr' => ['class' => 'mt-2 bg-transparent border-2 p-2 rounded-md w-full'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => ['class' => 'block text-xl mb-3 font-medium text-gray-700 font-semibold'],
                'attr' => [
                    'class' => 'mt-2 bg-transparent border-2 p-2 rounded-md w-full',
                    'type' => 'email',

                ],
                
            ])
            ->add('phone', NumberType::class, [
                'label' => 'Téléphone',
                'label_attr' => ['class' => 'block text-xl mb-3 font-medium text-gray-700 font-semibold'],
                'attr' => [
                    'class' => 'mt-2 bg-transparent border-2 p-2 rounded-md w-full',
                    'type' => 'numeric',
                ],
                'html5' => true,
                ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'label_attr' => ['class' => 'block text-xl mb-3 font-medium text-gray-700 font-semibold'],
                'attr' => ['class' => 'mt-2 bg-transparent border-2 p-2 rounded-md w-full'],
            ])
            ->add('city', NumberType::class, [
                'label' => 'Ville',
                'label_attr' => ['class' => 'block text-xl mb-3 font-medium text-gray-700 font-semibold'],
                'attr' => [
                    'class' => 'mt-2 bg-transparent border-2 p-2 rounded-md w-full',
                    'inputmode' => 'numeric',
                ],
                'html5' => true,
            ])
            ->add('agency', EntityType::class, [
                'label' => 'Agence',
                'label_attr' => ['class' => 'block text-xl mb-3 font-medium text-gray-700 font-semibold'],
                'attr' => [
                    'class' => 'mt-2 bg-transparent border-2 p-2 rounded-md w-full',
                    'inputmode' => 'numeric',
                ],
                'class' => Agency::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
