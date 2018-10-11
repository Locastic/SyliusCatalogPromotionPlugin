<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Form\Type;

use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductVariant;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CatalogPromotionGroupType extends AbstractResourceType
{
    /**
     * @var ProductVariantRepositoryInterface
     */
    private $productVariantRepository;

    public function __construct(string $dataClass, $validationGroups = [], ProductVariantRepositoryInterface $productVariantRepository)
    {
        $this->productVariantRepository = $productVariantRepository;

        parent::__construct($dataClass, $validationGroups);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('products', ChoiceType::class, [
                'choices' => $this->productVariantRepository->findBy([], [], 10),
                'choice_label' => function (ProductVariant $productVariant) {
                    return $productVariant;
                },
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('actions', PromotionActionCollectionType::class, [
                'label' => 'locastic.form.promotion.actions',
                'button_add_label' => 'locastic.form.catalog_promotion.add_action'
            ])
        ;

        $builder->get('products')->addModelTransformer(new CollectionToArrayTransformer());
    }

    public function getBlockPrefix()
    {
        return 'locastic_catalog_promotion_group';
    }
}
