<?php
namespace app\models\history\types;

use app\models\history\Created;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class CreatedType extends DoctrineGuidType
{
    const NAME = 'Type\History\Created';

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