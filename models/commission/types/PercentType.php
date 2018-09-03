<?php
namespace app\models\commission\types;

use app\models\commission\Percent;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class PercentType extends DoctrineGuidType
{
    const NAME = 'Type\Commission\Percent';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Percent */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Percent($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}