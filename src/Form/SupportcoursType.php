<?php

namespace App\Form;

use App\Entity\Supportcours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportcoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('languecours', ChoiceType::class, [
                'choices'  => [
                    'French' => 'French',
                    'English' => 'English',
                    'German' => 'German',
                ],
            ])
            ->add('photo',FileType::class, ['mapped' =>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Supportcours::class,
        ]);
    }
}