<?php

namespace App\Form;

use App\Entity\MovieRating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class   MovieRatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //   ->add('movie', NumberType::class)
            ->add('acting', NumberType::class)
            ->add('visual', NumberType::class)
            ->add('story', NumberType::class)
            ->add('entertainment_value', NumberType::class)
            ->add('historical_fidelity', NumberType::class)
            ->add('overall', NumberType::class)
            //     ->add('created_at')
            ->add('Submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MovieRating::class,
        ]);
    }
}
