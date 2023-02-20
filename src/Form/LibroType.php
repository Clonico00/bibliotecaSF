<?php

namespace App\Form;

use App\Entity\Libro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class LibroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new Regex(['pattern' => '/^[a-zA-Z0-9 ]+$/', 'message' => 'El título solo puede contener letras y números'])
                ]
            ])
            ->add('autor', Texttype::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new Regex(['pattern' => '/^[a-zA-Z ]+$/', 'message' => 'El nombre del autor solo puede contener letras'])
                ]
            ])
            ->add('editorial', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new Regex(['pattern' => '/^[a-zA-Z0-9 ]+$/', 'message' => 'El nombre de la editorial solo puede contener letras y números'])
                ]
            ])
            ->add('genero', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new Regex(['pattern' => '/^[a-zA-Z]+$/', 'message' => 'El género solo puede contener letras'])
                ]
            ])
            ->add('numero_ejemplares', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new GreaterThan(['value' => 0, 'message' => 'El número de ejemplares debe ser mayor que 0'])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Libro::class,
        ]);
    }
}
