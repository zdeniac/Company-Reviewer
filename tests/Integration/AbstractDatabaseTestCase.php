<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractDatabaseTestCase extends KernelTestCase
{
    protected EntityManagerInterface $em;

    protected function setUp(): void
    {
        self::bootKernel(['environment' => 'test', 'debug' => true]);

        $this->em = static::getContainer()->get(EntityManagerInterface::class);

        $this->clearDatabase();
    }

    protected function clearDatabase(): void
    {
        $this->em->createQuery('DELETE FROM App\Entity\Review r')->execute();
    }
}