<?php

namespace App\Tests\Service;

use App\Repository\UrlRepository;
use App\Service\UrlService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as TestCase;

class UrlServiceTest extends TestCase
{
    /** @test */
    public function getTagByUrlThrowNotFound(): void
    {
        $this->expectException(EntityNotFoundException::class);

        $repository = $this->createMock(UrlRepository::class);
        $container = static::getContainer();
        $container->set(UrlRepository::class, $repository);

        $context = $container->get(UrlService::class);
        $result = $context->getTagByUrl('ojiosdjiojsojoid');
    }
}
