<?php
namespace app\models\commission\types;

use app\models\commission\Created;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class CreatedType extends DoctrineGuidType
{
    const NAME = 'Type\Commission\Created';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Created */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Created($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}