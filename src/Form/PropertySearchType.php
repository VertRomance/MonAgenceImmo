<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\PropertySearch;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Choice;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice', IntegerType::class, [
                'required' =>false,
                'label' =>false,
                'attr' =>[
                    'placeholder'=>'Budget max'
                ]
            ])
            ->add('minSurface', IntegerType::class, [
                'required' =>false,
                'label' =>false,
                'attr' =>[
                    'placeholder'=>'Surface minimale'
                ]
            ])
            ->add('options', EntityType::class, [
                'required' =>false,
                'label' => false,
                'mapped' => false,
                'class' => Option::class,
                'query_builder' => function(EntityRepository $er)
                    {
                        return $er->createQueryBuilder('o')
                        ->orderBy('o.name', 'ASC');
                    },
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                // 'allow_add' => true
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method'=>'get',
            'crsf_protection'=>'false',
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
