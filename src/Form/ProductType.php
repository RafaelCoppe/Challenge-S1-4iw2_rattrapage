<?php

namespace App\Form;

use App\Entity\Agency;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label')
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'transport' => "transport",
                    'activité' => "activité",
                    'logement' => "logement",
                    'restauration' => "restauration",
                    'autre' => "autre",
                ],
            ])
            ->add('tax');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
