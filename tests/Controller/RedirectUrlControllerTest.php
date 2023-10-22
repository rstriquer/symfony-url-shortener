<?php

namespace App\Tests\Controller;

use App\Controller\RedirectUrlController;
use App\Service\UrlService;
use App\Tests\Trait\RebuildDatabaseTrait;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RedirectUrlControllerTest extends WebTestCase
{
    use RebuildDatabaseTrait;

    /**
     * @test
     */
    public function class_has_instantiate_with_default_services(): void
    {
        $service = $this->createMock(UrlService::class);
        $logger = $this->createMock(LoggerInterface::class);

        $context = new RedirectUrlController($service, $logger);

        $this->assertInstanceOf(RedirectUrlController::class, $context);
    }
}
