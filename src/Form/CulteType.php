<?php

namespace App\Form;

use App\Entity\Culte;
use App\Entity\TypeCulte;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CulteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-3 col-sm-6 mr-2',
                ],
            ])
            ->add('dateculte', TextType::class, [
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'date'
                ],
                'row_attr' => [
                    'class' => 'col-md-3 col-sm-6 mr-2',
                ],
            ])
            ->add('effectif', IntegerType::class, [
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-3 col-sm-6 mr-2',
                ],
            ])
            ->add('nouveauVenu', IntegerType::class, [
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-md-3 col-sm-6 mr-2',
                ],
            ])
            ->add('typeCulte', EntityType::class, [
                'class' => TypeCulte::class,
                'choice_label' => 'libelle',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
                'row_attr' => [
                    'class' => 'col-md-3 col-sm-6 mr-2 mb-3',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Culte::class,
        ]);
    }
}
