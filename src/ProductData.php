<?php
namespace SnowIO\Magento2DataModel;

class ProductData
{

    const ENABLED = 1;
    const CATALOG_SEARCH = 4;
    const CATALOG = 2;
    const SEARCH = 3;
    const NOT_VISIBLE_INDIVIDUALLY = 1;
    const SIMPLE_PRODUCT = 'simple';
    const DEFAULT_ATTRIBUTE_SET = 'default';
    private const ATTRIBUTE_SET_CODE = 'attribute_set_code';

    public static function of(string $sku): self
    {
        $productData = new self($sku);
        $productData->status = self::ENABLED;
        $productData->visibility = self::CATALOG_SEARCH;
        $productData->typeId = self::SIMPLE_PRODUCT;
        $productData->extensionAttributes[self::ATTRIBUTE_SET_CODE] = self::DEFAULT_ATTRIBUTE_SET;
        return $productData;
    }

    public function withVisibility(int $visibility): self
    {
        $this->validateVisibility($visibility);
        $result = clone $this;
        $result->visibility = $visibility;
        return $result;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getVisibility(): int
    {
        return $this->visibility;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getTypeId(): string
    {
        return $this->typeId;
    }

    public function getAttributeSetCode(): string
    {
        return $this->extensionAttributes[self::ATTRIBUTE_SET_CODE];
    }

    private function validateVisibility($visibility)
    {
        $validVisibilities = [
            self::NOT_VISIBLE_INDIVIDUALLY,
            self::CATALOG,
            self::SEARCH,
            self::CATALOG_SEARCH
        ];

        if (!in_array($visibility, $validVisibilities)) {
            throw new \InvalidArgumentException('Invalid Visibility');
        }
    }

    public function toJson(): array
    {
        $json = [];
        $json['sku'] = $this->sku;
        $json['status'] = $this->status;
        $json['visibility'] = $this->visibility;
        $json['price'] = $this->price;
        $json['type_id'] = $this->typeId;
        $json['extension_attributes'] = $this->extensionAttributes;
        return $json;
    }

    private $sku;
    private $status;
    private $visibility;
    private $price;
    private $typeId;
    private $extensionAttributes = [];

    private function __construct($sku)
    {
        $this->sku = $sku;
    }
}
