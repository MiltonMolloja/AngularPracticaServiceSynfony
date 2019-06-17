<?php

namespace App\Form;

use App\Entity\Divisa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DivisaType extends AbstractType
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
            ->add('cliente')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Divisa::class,
        ]);
    }
}
