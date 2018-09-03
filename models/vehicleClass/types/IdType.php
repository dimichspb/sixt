<?php
namespace app\models\vehicleClass\types;

use app\models\vehicleClass\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class IdType extends DoctrineGuidType
{
    const NAME = 'Type\VehicleClass\Id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Id */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Id($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}