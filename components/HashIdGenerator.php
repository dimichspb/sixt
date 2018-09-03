<?php
namespace app\components;

use Doctrine\ORM\Id\AbstractIdGenerator;

class HashIdGenerator extends AbstractIdGenerator
{
    public function generate(\Doctrine\ORM\EntityManager $em, $entity)
    {
        return md5(serialize($entity));
    }
}