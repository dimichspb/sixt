<?php
namespace app\models\vehicleClass\types;

use app\models\vehicleClass\Example;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class ExampleType extends DoctrineGuidType
{
    const NAME = 'Type\VehicleClass\Example';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Example */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Example($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}