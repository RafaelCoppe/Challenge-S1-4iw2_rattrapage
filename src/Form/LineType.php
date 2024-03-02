<?php

namespace App\Form;

use App\Entity\Line;
use App\Entity\Product;
use App\Entity\Quotation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('place')

            /*->add('category', EntityType::class, [
                'label' => 'Catégorie du produit',
                'required'=>true,
                'placeholder' => 'Choisir une catégorie',
                'class' => Product::class,
            ])*/

            ->add('product', EntityType::class, [
                'label' => 'Produit : ', 
                'class' => Product::class,
                'choice_label' => 'label',
            ])
            ->add('additional', null, [
                'label' => 'Informations : ',
                'required'=>true,
                'attr' => [
                    'placeholder' => 'Plus d\'informations...',
                ],
            ])
            ->add('unit_price', null, [
                'label' => 'Prix : ',
                'required'=>true,
                'attr' => [
                    'placeholder' => '0.00€',
                ],
            ])
            ->add('quantity', null, [
                'label' => 'Quantité : ',
                'required'=>true,
                'attr' => [
                    'placeholder' => 'Indiquez la quantité',
                ],
            ])
            
             
            //->add('quote', EntityType::class, [
            //    'class' => Quotation::class,
            //    'choice_label' => 'id',
            //])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Line::class,
        ]);
    }
}
