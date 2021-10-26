<?php

declare(strict_types = 1);

namespace App\Form;

use App\Entity\Attribute;
use App\Entity\VehicleAttribute;
use App\Repository\AttributeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleAttributeEmbeddedForm extends AbstractType
{
    /**
     * @var \App\Repository\AttributeRepository
     */
    private AttributeRepository $attributeRepository;

    /**
     * @param \App\Repository\AttributeRepository $attributeRepository
     */
    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('attribute', EntityType::class, [
                'class' => Attribute::class,
                'choice_label' => 'name',
            ])
            ->add('value')
        ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VehicleAttribute::class
        ]);
    }
}
