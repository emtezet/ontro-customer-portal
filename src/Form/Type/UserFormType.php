<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


/**
 * Class UserFormType
 * @package App\Form\Type
 */
class UserFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('id', HiddenType::class)
            ->add('email', TextType::class, [
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'col-12 col-md-3 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-9 p-0'
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
                'label_attr' => [
                    'class' => 'col-12 col-md-3 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-9 p-0'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'label_attr' => [
                    'class' => 'col-12 col-md-3 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-9 p-0'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'label_attr' => [
                    'class' => 'col-12 col-md-3 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-9 p-0'
                ]
            ])
            ->add('country', TextType::class, [
                'label' => 'Country',
                'label_attr' => [
                    'class' => 'col-12 col-md-3 p-0 justify-content-start'
                ],
                'attr' => [
                    'class' => 'form-control-sm col-12 col-md-9 p-0'
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'user_formtype';
    }
}
