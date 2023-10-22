<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\UrlService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UrlController extends AbstractController
{
    protected UrlService $service;
    protected LoggerInterface $logger;

    public function __construct(UrlService $service, LoggerInterface $logger)
    {
        $this->service = $service;
        $this->logger = $logger;
    }
}