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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
                'required' => false,
                'label' => false,
                'class' => Category::class,
                'placeholder' => 'Select a category',
                'mapped' => false,
                'choice_label' => "name"
            ])
            ->add('subcategory', EntityType::class,[
                'required' => false,
                'label' => false,
                'class' => SubCategory::class,
                'placeholder' => 'Select a category',
                'mapped' => false,
                'choice_label' => "name"
            ])
            ->add('imageFile',FileType::class,[
                'required' => false
            ])
        ;

        $builder->get('category')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
                $this->addSubCategoryField($form->getParent(), $form->getData());
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event)
            {
                $form = $event->getForm();
                $data = $event->getData();

                dump($data);
                /* @var $subcategory SubCategory */
                $subcategory = $data->getSubcategory();

                if ($subcategory)
                {
                    dump("C'est blindé");
                    $category = $subcategory->getCategory();
                    $this->addSubCategoryField($form, $category);
                    $form->get('title')->setData($data->getTitle());
                    $form->get('price')->setData($data->getPrice());
                    $form->get('category')->setData($category);
                    $form->get('subcategory')->setData($subcategory);
                }
                else
                {
                    dump("C'est nul");
                    $this->addSubCategoryField($form, null);
                }
            }
        );
    }

    /**
     * Rajoute un champ subcategory dans le formulaire
     * @param FormInterface $form
     * @param Category $category
     */
    private function addSubCategoryField(FormInterface $form, ?Category $category)
    {
        if (null === $category)
            return;

        $builder = $form->getConfig()->getFormFactory()
            ->createNamedBuilder(
                'subcategory',
                EntityType::class,
                null,
                [
                    'required' => false,
                    'label' => false,
                    'class' => SubCategory::class,
                    'placeholder' => $category ? 'Select a category' : 'Please preselect',
                    'mapped' => true,
                    'choice_label' => "name",
                    'auto_initialize' => false,
                    'choices' => $category ? $category->getSubcategory() : []
                ]);

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                dump($event->getForm());
            }
        );

        $form->add($builder->getForm());
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }
}
