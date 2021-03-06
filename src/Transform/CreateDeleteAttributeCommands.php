<?php
namespace SnowIO\Magento2DataModel\Transform;

use Joshdifabio\Transform\Distinct;
use Joshdifabio\Transform\MapElements;
use Joshdifabio\Transform\Pipeline;
use Joshdifabio\Transform\Transform;
use SnowIO\Magento2DataModel\AttributeData;
use SnowIO\Magento2DataModel\Command\DeleteAttributeCommand;

final class CreateDeleteAttributeCommands
{
    public static function fromIterables(): Transform
    {
        return Pipeline::of(
            GetDeletedItems::fromIterables(function (AttributeData $attributeData) {
                return $attributeData->getCode();
            }),
            self::fromAttributeData()
        );
    }

    public static function fromAttributeData(): Transform
    {
        return Pipeline::of(
            MapElements::via(function (AttributeData $previousAttributeData) {
                return $previousAttributeData->getCode();
            }),
            self::fromAttributeCodes()
        );
    }

    public static function fromAttributeCodes(): Transform
    {
        return Pipeline::of(
            Distinct::create(),
            MapElements::via(function (string $attributeCode) {
                return DeleteAttributeCommand::of($attributeCode);
            })
        );
    }
}
