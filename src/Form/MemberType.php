<?php

namespace App\Form;

use App\Entity\Agency;
use App\Entity\Member;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('status')
            ->add('gender')
            ->add('lastname')
            ->add('firstname')
            ->add('mail')
            ->add('phone')
            ->add('address')
            ->add('city')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Salarié' => "ROLE_USER",
                    'Comptable' => 'ROLE_ACCOUNTANT',
                    'Directeur' => "ROLE_AGENCY_BOSS",
                    'Administrateur' => "ROLE_ADMIN",
                    // Add more roles as needed
                ],
                'multiple' => false,
                'property_path' => 'role',
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
