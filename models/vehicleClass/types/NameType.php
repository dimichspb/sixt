<?php
namespace app\models\vehicleClass\types;

use app\models\vehicleClass\Name;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class NameType extends DoctrineGuidType
{
    const NAME = 'Type\VehicleClass\Name';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Name */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Name($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}