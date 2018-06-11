<?php
namespace SnowIO\Magento2DataModel\Transform;

use Joshdifabio\Transform\MapElements;
use Joshdifabio\Transform\Pipeline;
use Joshdifabio\Transform\Transform;
use SnowIO\Magento2DataModel\CustomerData;
use SnowIO\Magento2DataModel\Command\SaveCustomerCommand;

final class CreateSaveCustomerCommands
{
    public static function fromIterables(): Transform
    {
        return Pipeline::of(
            CreateDiffs::fromIterables(function (CustomerData $customerData) {
                return $customerData->getEmail();
            }),
            self::fromDiffs()
        );
    }

    public static function fromDiffs(): Transform
    {
        return CreateSaveCommands::fromDiffs(self::fromCustomerData());
    }

    public static function fromCustomerData(): Transform
    {
        return MapElements::via(function (CustomerData $customerData) {
            return SaveCustomerCommand::of($customerData);
        });
    }
}
