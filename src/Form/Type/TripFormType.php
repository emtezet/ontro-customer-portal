<?php

namespace App\Form\Type;

use App\Entity\Passenger;
use App\Entity\Trip;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


/**
 * Class TripFormType
 * @package App\Form\Type
 */
class TripFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('id', HiddenType::class)
            ->add('fromAirport', TextType::class, [
                'label' => 'Departure airport',
                'label_attr' => [
                    'class' => 'col-12 col-md-3 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-9 p-0'
                ]
            ])
            ->add('toAirport', TextType::class, [
                'label' => 'Destination airport',
                'label_attr' => [
                    'class' => 'col-12 col-md-3 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-9 p-0'
                ]
            ])
            ->add('departure', DateTimeType::class, [
                'input' => 'datetime',
                'widget' => 'single_text',
                'years' => range(date('Y'), date('Y') + 3),
                'label' => 'Departure date',
                'label_attr' => [
                    'class' => 'col-12 col-md-5 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-7 p-0'
                ]
            ])
            ->add('arrival', DateTimeType::class, [
                'input' => 'datetime',
                'widget' => 'single_text',
                'years' => range(date('Y'), date('Y') + 3),
                'label' => 'Arrival date',
                'label_attr' => [
                    'class' => 'col-12 col-md-5 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-7 p-0'
                ]
            ])
            ->add('passengers', EntityType::class, [
                    'label' => 'Passengers',
                    'class' => Passenger::class,
                    'multiple' => true,
                    'expanded' => true
                ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Trip::class
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'trip_formtype';
    }
}
