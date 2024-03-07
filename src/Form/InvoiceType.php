<?php

namespace App\Form;

use App\Entity\Invoice;
use App\Entity\Quotation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->city_choices = $options['city_choices'];
        $this->quotes_choices = $options['quotes_choices'];

        $builder
            ->add('terms')
            ->add('payment_lastname')
            ->add('payment_firstname')
            ->add('payment_email')
            ->add('payment_phone')
            ->add('payment_address')
            ->add('payment_city', ChoiceType::class, [
                'choices' => $this->city_choices,
            ]);

        // N'affiche le choix de la quote que si l'invoice est nouveau
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
            $invoice = $event->getData();
            $form = $event->getForm();

            if (!$invoice || null === $invoice->getId()) {
                $form->add('quote', ChoiceType::class, [
                    'choices' => $this->quotes_choices,
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
            'city_choices' => null,
            'quotes_choices' => null,
        ]);
    }
}
