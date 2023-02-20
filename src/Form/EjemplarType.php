<?php

namespace App\Form;

use App\Entity\Ejemplar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class EjemplarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('estado', Texttype::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new Regex(['pattern' => '/^[a-zA-Z ]+$/', 'message' => 'El estado solo puede contener letras'])
                ]
            ])
            ->add('estanteria', Texttype::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new Regex(['pattern' => '/^[a-zA-Z0-9 ]+$/', 'message' => 'La estantería solo puede contener letras y números'])
                ]
            ])
            ->add('edicion', Texttype::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new Regex(['pattern' => '/^[a-zA-Z0-9  ]+$/', 'message' => 'La edición solo puede contener letras y números'])
                ]
            ])
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
