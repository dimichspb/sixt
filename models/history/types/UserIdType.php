<?php
namespace app\models\history\types;

use app\models\history\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class UserIdType extends DoctrineGuidType
{
    const NAME = 'Type\History\UserId';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value UserId */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new UserId($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}