<?php

use PHPUnit\Framework\TestCase;
use SnowIO\Magento2DataModel\ProductData;
use SnowIO\Magento2DataModel\ProductType;
use SnowIO\Magento2DataModel\VisibilityType;

class ProductDataTest extends TestCase
{
    public function testInitialization()
    {
        $product = ProductData::of('snowio-test-product');
        self::assertEquals([
            'sku' => 'snowio-test-product',
            'status' => 1,
            'visibility' => 4,
            'price' => null,
            'type_id' => 'simple',
            'extension_attributes' => [
                'attribute_set_code' => 'default'
            ]
        ],$product->toJson());
    }

    public function testAccessors()
    {
        $product = ProductData::of('snowio-test-product');
        self::assertEquals('snowio-test-product', $product->getSku());
        self::assertEquals(ProductData::ENABLED, $product->getStatus());
        self::assertEquals(VisibilityType::CATALOG_SEARCH, $product->getVisibility());
        self::assertEquals(null, $product->getPrice());
        self::assertEquals(ProductType::SIMPLE, $product->getTypeId());
        self::assertEquals(ProductData::DEFAULT_ATTRIBUTE_SET, $product->getAttributeSetCode());
    }

    /**
     * Visibility should only be the following
     * not_visible_individually -> 1
     * catalog -> 2
     * search -> 3
     * catalog_search -> 4
     * Any other visibility value is invalid
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid Visibility
     */
    public function testWithInvalidVisibility()
    {
        ProductData::of('snowio-test-product')
            ->withVisibility(5);
    }

}