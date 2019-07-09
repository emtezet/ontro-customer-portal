<?php

namespace App\Form\Type;

use App\Entity\Passenger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


/**
 * Class PassengerFormType
 * @package App\Form\Type
 */
class PassengerFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('id', HiddenType::class)
            ->add('title', ChoiceType::class, [
                'choices' => [
                    'Mr.' => 'Mr.',
                    'Mrs.' => 'Mrs.',
                    'Ms.' => 'Ms.',
                    'Miss' => 'Miss'
                ],
                'multiple' => false,
                'expanded' => false,
                'label' => 'Title',
                'label_attr' => [
                    'class' => 'col-12 col-md-5 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-7 p-0'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Firstname',
                'label_attr' => [
                    'class' => 'col-12 col-md-3 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-9 p-0'
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => 'Surname',
                'label_attr' => [
                    'class' => 'col-12 col-md-3 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-9 p-0'
                ]
            ])
            ->add('passportId', TextType::class, [
                'label' => 'Passport ID',
                'label_attr' => [
                    'class' => 'col-12 col-md-3 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-9 p-0'
                ]
            ])
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Passenger::class
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'passenger_formtype';
    }
}
