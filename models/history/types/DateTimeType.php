<?php
namespace app\models\history\types;

use app\models\history\DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class DateTimeType extends DoctrineGuidType
{
    const NAME = 'Type\History\DateTime';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value DateTime */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new DateTime($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}