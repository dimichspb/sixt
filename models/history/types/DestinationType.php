<?php
namespace app\models\history\types;

use app\models\history\Destination;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class DestinationType extends DoctrineGuidType
{
    const NAME = 'Type\History\Destination';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Destination */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Destination($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}