<?php

namespace App\Form;

use App\Entity\Moneda;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Moneda1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('compra')
            ->add('venta')
            ->add('montoRecibido')
            ->add('montoEntregado')
            ->add('tipoCambio')
            ->add('fecha')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Moneda::class,
        ]);
    }
}
