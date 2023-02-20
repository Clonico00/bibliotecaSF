<?php

namespace App\Form;

use App\Entity\Prestamo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
                'invalid_message' => 'La fecha de devolución no puede ser anterior a la fecha actual.',
                'constraints' => [
                    new Callback([$this, 'validateFechas']),
                ],
            ])
            ->add('fecha_retiro', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d') // Establece el mínimo a la fecha actual
                ],
                'invalid_message' => 'La fecha de retiro no puede ser anterior a la fecha actual.',

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

    /**
     * @Assert\Callback
     */
    public function validateFechas($value, ExecutionContextInterface $context)
    {
        $fechaRetiro = $context->getRoot()->get('fecha_retiro')->getData();
        $fechaDevolucion = $context->getRoot()->get('fecha_devolucion')->getData();

        if ($fechaDevolucion < $fechaRetiro) {
            $context->buildViolation('La fecha de devolución no puede ser anterior a la fecha de retiro.')
                ->atPath('fechaDevolucion')
                ->addViolation();
        }
    }

}
