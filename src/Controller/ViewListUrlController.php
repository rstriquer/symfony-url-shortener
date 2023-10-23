<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controls the action of displaying the system home and url listing view page
 */
class ViewListUrlController extends UrlController
{
    #[Route('/', name: 'public_home', methods: ['GET'])]
    public function index(Request $payload): Response
    {
        $viewData = $this->service->list(
            $this->createFormBuilder(),
            $payload
        );

        return $this->render('view_list_url/index.html.twig', $viewData);
    }
}
