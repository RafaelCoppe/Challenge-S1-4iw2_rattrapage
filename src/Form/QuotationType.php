<?php

namespace App\Form;

use App\Entity\Agency;
use App\Entity\Client;
use App\Entity\Invoice;
use App\Entity\Quotation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuotationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('terms',null, [
                'label' => 'Nom : ',
                'required'=>true,
                'attr' => [
                    'placeholder' => 'Nom du devis',
                ],
            ])
            //->add('status')
            ->add('start_date', null, [
                'label' => 'Date de début : ',
                'required'=>true,
            ])
            ->add('end_date', null, [
                'label' => 'Date de fin : ',
                'required'=>true,
            ])
            ->add('duration', null, [
                'label' => 'Durée du voyage : ',
                'required'=>true,
                'attr' => [
                    'placeholder' => 'Insérez la durée',
                ],
            ])
            //->add('ref')
            //->add('invoice', EntityType::class, [
            //  'class' => Invoice::class,
            //  'choice_label' => 'id',
            //])
            //->add('agency', EntityType::class, [ //A retirer quand on aura le login fonctionnel
            //    'label' => 'Agence : ',
            //    'class' => Agency::class,
            //    'choice_label' => 'name',
            //])
            ->add('client', EntityType::class, [
                'label' => 'Client : ',
                'class' => Client::class,
                'choice_label' => 'lastname',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quotation::class,
        ]);
    }
}
