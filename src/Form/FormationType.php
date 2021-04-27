<?php

namespace App\Form;
use Symfony\Component\Mime;
use Symfony\Flex\SymfonyBundle;
use App\Entity\Formation;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('volumeHoraire')
            ->add('mode_enseignement',ChoiceType::class, [
                'choices'  => [
                    'en ligne'=> 'en ligne' ,
                    'presentiel'=> 'presentiel',
                ],
            ])
            ->add('Langue', ChoiceType::class, [
                'choices'  => [
                    'French' => 'French',
                    'English' => 'English',
                    'German' => 'German',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}