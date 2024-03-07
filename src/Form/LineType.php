<?php

namespace App\Form;

use App\Entity\Line;
use App\Entity\Product;
use App\Entity\Quotation;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class LineType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
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
                'class' => Product::class,
                'label' => 'Produit : ', 
                'choice_label' => 'label',
                'query_builder' => function (ProductRepository $productRepository) {
                    $agencyId = $this->security->getUser()->getAgency()->getId();
                    return $productRepository->createQueryBuilder('p')
                        ->where('p.agency = :agencyId')
                        ->setParameter('agencyId', $agencyId);
                },
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Line::class,
        ]);
    }
}
