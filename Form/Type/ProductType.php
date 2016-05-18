<?php
// src/Nicolas/EshopBundle/Form/ProductType.php

namespace Nicolas\EshopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Nicolas\BlogBundle\Form\ImageType;
use Nicolas\BlogBundle\Form\DataTransformer\SlugifyTransformer;

/**
 *
 **/
class ProductType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('title')
                        ->add('slug')
                        ->add('description', TextareaType::class)
			->add('content', TextareaType::class)
			->add('publishedDate', DateType::class, array(
				'input'  => 'timestamp',
				'widget' => 'choice',
				'attr' => array(
				)
			))
			->add('image', ImageType::class)
			->add('published', ChoiceType::class, array(
				'choices' => array(
					'Yes' => 1,
					'No' => 0,
				),
				'multiple' => false,
				'expanded' => true,
			));
                
                $builder->get('slug')
                    ->addModelTransformer(new SlugifyTransformer());
	}


}