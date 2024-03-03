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
            ->add('terms')
            //->add('status')
            ->add('start_date')
            ->add('end_date')
            ->add('duration')
            //->add('ref')
            //->add('invoice', EntityType::class, [
            //  'class' => Invoice::class,
            //  'choice_label' => 'id',
            //])
            ->add('agency', EntityType::class, [
                'class' => Agency::class,
                'choice_label' => 'name',
            ])
            ->add('client', EntityType::class, [
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
