<?php

declare(strict_types=1);

namespace App\Trait;

trait EntityManagerFlushTrait
{
    /**
     * Flush an entity into the Entity Manager
     * @param $entity A Doctrine entity object
     * @throws \Exception Could throw any kind of Doctrine available exception
     */
    public function flush($entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}
