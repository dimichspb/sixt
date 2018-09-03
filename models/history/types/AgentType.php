<?php
namespace app\models\history\types;

use app\models\history\Agent;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType as DoctrineGuidType;

class AgentType extends DoctrineGuidType
{
    const NAME = 'Type\History\Agent';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Agent */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Agent($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}