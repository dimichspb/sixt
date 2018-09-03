<?php
namespace app\models\vehicleClass\types;

use app\models\vehicleClass\Title;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class TitleType extends DoctrineGuidType
{
    const NAME = 'Type\VehicleClass\Title';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Title */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Title($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}