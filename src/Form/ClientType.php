<?php

namespace App\Form;

use App\Entity\Agency;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->traitChoices = $options['trait_choices'];

        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('email')
            ->add('phone')
            ->add('address')
            ->add('city');}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'trait_choices' => null,
        ]);
    }
}
