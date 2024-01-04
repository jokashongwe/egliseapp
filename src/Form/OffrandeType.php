<?php

namespace App\Form;

use App\Entity\Culte;
use App\Entity\Offrande;
use App\Entity\TypeOffrande;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffrandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('montantFC')
            ->add('montantUSD')
            ->add('montantEUR')
            ->add('createdAt')
            ->add('typeOffrande', EntityType::class, [
                'class' => TypeOffrande::class,
'choice_label' => 'id',
            ])
            ->add('culte', EntityType::class, [
                'class' => Culte::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offrande::class,
        ]);
    }
}
