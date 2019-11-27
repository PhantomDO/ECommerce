<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Property;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('price')
            ->add('description')
            ->add('city', ChoiceType::class, [
                'choices' => [
                    'Lyon' => 'Lyon',
                    'Marseille' => 'Marseille'
                ]
            ])
            ->add('category', EntityType::class,[
                'class' => Category::class,
                'choice_label' => "name"
            ])
            ->add('subcategory', EntityType::class,[
                'class' => SubCategory::class,
                'choice_label' => "name"
            ])
            ->add('imageFile',FileType::class,[
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }
}
