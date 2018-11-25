<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Form\Type;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionGroupInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\Product;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductVariant;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\ArrayToPartsTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CatalogPromotionGroupType extends AbstractResourceType
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(string $dataClass, $validationGroups = [], ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;

        parent::__construct($dataClass, $validationGroups);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('products', ChoiceType::class, [
                'choices' => $this->productRepository->findBy([], [], 100),
                'choice_label' => function (ProductInterface $productVariant) {
                    return $productVariant;
                },
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('actions', PromotionActionCollectionType::class, [
                'label' => 'locastic.form.catalog.actions',
                'button_add_label' => 'locastic.form.catalog.add_action'
            ])
        ;

        $builder->get('products')->addModelTransformer(new CollectionToArrayTransformer());
    }

    public function getBlockPrefix()
    {
        return 'locastic_catalog_promotion_group';
    }
}
