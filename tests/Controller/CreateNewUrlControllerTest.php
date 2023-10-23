<?php

namespace App\Tests\Controller;

use App\Controller\CreateNewUrlController;
use App\Service\UrlService;
use App\Tests\Trait\RebuildDatabaseTrait;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateNewUrlControllerTest extends WebTestCase
{
    use RebuildDatabaseTrait;

    /**
     * @test
     */
    public function classHasInstantiateWithDefaultServices(): void
    {
        $service = $this->createMock(UrlService::class);
        $logger = $this->createMock(LoggerInterface::class);

        $context = new CreateNewUrlController($service, $logger);

        $this->assertInstanceOf(CreateNewUrlController::class, $context);
    }
}
