<?php

namespace App\Form;

use App\Entity\Agency;
use App\Entity\Member;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('roles')
            ->add('create_date')
            ->add('update_date')
            ->add('delete_date')
            ->add('agencies', EntityType::class, [
                'class' => Agency::class,
'choice_label' => 'id',
'multiple' => true,
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
