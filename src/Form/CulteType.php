<?php

namespace App\Form;

use App\Entity\Culte;
use App\Entity\TypeCulte;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CulteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('createdAt')
            ->add('dateculte')
            ->add('effectif')
            ->add('nouveauVenu')
            ->add('typeCulte', EntityType::class, [
                'class' => TypeCulte::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Culte::class,
        ]);
    }
}
