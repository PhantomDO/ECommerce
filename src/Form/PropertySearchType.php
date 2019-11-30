<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\PropertySearch;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\PropertyRepository;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('keyword')
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix Maximal'
                ]
            ])
            ->add('category', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Category::class,
                'placeholder' => 'Select a category',
                'mapped' => true,
                'choice_label' => "name"
            ])

            ->add('subcategory', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => SubCategory::class,
                'placeholder' => 'Select a category',
                'mapped' => true,
                'choice_label' => "name"
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

                //dump($data);
                /* @var $subcategory SubCategory */
                $subcategory = $data->getSubcategory();

                if (null !== $subcategory)
                {
                    //dump("C'est blindé");
                    $category = $subcategory->getCategory();
                    $this->addSubCategoryField($form, $category);
                    $form->get('category')->setData($category);
                    $form->get('subcategory')->setData($subcategory);
                }
                else
                {
                    //dump("C'est nul");
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
                //dump($event->getForm());
            }
        );

        $form->add($builder->getForm());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return;
    }
}
