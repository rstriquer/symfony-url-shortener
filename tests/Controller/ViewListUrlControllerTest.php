<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Controller\ViewListUrlController;
use App\Service\UrlService;
use App\Tests\Trait\RebuildDatabaseTrait;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ViewListUrlControllerTest extends WebTestCase
{
    use RebuildDatabaseTrait;

    /**
     * @test
     */
    public function class_has_instantiate_with_default_services(): void
    {

        $service = $this->createMock(UrlService::class);
        $logger = $this->createMock(LoggerInterface::class);

        $context = new ViewListUrlController($service, $logger);

        $this->assertInstanceOf(ViewListUrlController::class, $context);
    }

    /**
     * @test
     */
    public function response_200_ok(): void
    {
        // $this->markTestSkipped('fix: ErrorException');
        $crowler = $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', '(Simple) Symfony URL Shortener');
    }
}
