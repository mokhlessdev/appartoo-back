<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', TextType::class, array('required' => true,
                    'label' => 'Nom ',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                ))
                ->add('email', TextType::class, array('required' => true,
                    'label' => 'Email ',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                ))
                ->add('age')
                ->add('famille')
                ->add('nourriture')
                ->add('race')
        ;
    }

    public function getParent() {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix() {
        return 'app_user_profile';
    }

    public function getName() {
        return $this->getBlockPrefix();
    }

}
