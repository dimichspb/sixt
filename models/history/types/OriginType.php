<?php
namespace app\models\history\types;

use app\models\history\Origin;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class OriginType extends DoctrineGuidType
{
    const NAME = 'Type\History\Origin';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Origin */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Origin($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}