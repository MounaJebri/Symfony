<?php

namespace BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
                ->add('price')
                ->add('description')
                ->add('category',ChoiceType::class, [
                    'choices' => [
                        'Clothing'  => [
                            'Shoes' => 'Shoes',
                            'Jeans' => 'Jeans',
                            'T-shirt' => 'Tshirt',
                        ],'Technology'  => [
                            'Mice' => 'Mice',
                            'Keyboard' => 'Keyboard',
                            'HeadSet' => 'HeadSet',
                        ],
                    ],
                ])
                ->add('quantity')
                ->add('imageFile',VichImageType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BaseBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'basebundle_product';
    }


}
