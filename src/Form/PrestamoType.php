<?php

namespace App\Form;

use App\Entity\Prestamo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestamoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha_devolucion', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d') // Establece el mínimo a la fecha actual
                ],
                'invalid_message' => 'La fecha de devolución no puede ser anterior a la fecha actual.'
            ])
            ->add('fecha_retiro', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d') // Establece el mínimo a la fecha actual
                ],
                'invalid_message' => 'La fecha de retiro no puede ser anterior a la fecha actual.'
            ])
            ->add('socio')
            ->add('ejemplar')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prestamo::class,
        ]);
    }
}
