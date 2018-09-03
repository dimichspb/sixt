<?php
namespace app\models\history\types;

use app\models\history\Ip;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class IpType extends DoctrineGuidType
{
    const NAME = 'Type\History\Ip';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Ip */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Ip($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}