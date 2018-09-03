<?php
namespace app\models\history\types;

use app\models\history\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class TypeType extends DoctrineGuidType
{
    const NAME = 'Type\History\Type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Type */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Type($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}