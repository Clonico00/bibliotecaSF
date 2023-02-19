<?php

namespace App\Form;

use App\Entity\Ejemplar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EjemplarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('estado')
            ->add('estanteria')
            ->add('edicion')
            ->add('libro')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ejemplar::class,
        ]);
    }
}
