<?php

namespace SprykerFeature\Zed\ProductSearch\Business;

use SprykerEngine\Shared\Kernel\Messenger\MessengerInterface;
use SprykerEngine\Shared\Locale\Dto\LocaleDto;
use SprykerEngine\Zed\Kernel\Business\AbstractFacade;

/**
 * @method ProductSearchDependencyContainer getDependencyContainer()
 */
class ProductSearchFacade extends AbstractFacade
{
    /**
     * @param array $productsRaw
     * @param array $processedProducts
     *
     * @return array
     */
    public function enrichProductsWithSearchAttributes(array $productsRaw, array $processedProducts)
    {
        return $this->getDependencyContainer()
            ->getProductAttributesTransformer()
            ->buildProductAttributes($productsRaw, $processedProducts);
    }

    /**
     * @param array $productsRaw
     * @param array $processedProducts
     * @param LocaleDto $locale
     *
     * @return array
     */
    public function createSearchProducts(array $productsRaw, array $processedProducts, LocaleDto $locale)
    {
        return $this->getDependencyContainer()
            ->getProductSearchProcessor()
            ->buildProducts($productsRaw, $processedProducts, $locale);
    }

    /**
     * @param MessengerInterface $messenger
     */
    public function install(MessengerInterface $messenger)
    {
        $this->getDependencyContainer()->getInstaller($messenger)->install();
    }
}