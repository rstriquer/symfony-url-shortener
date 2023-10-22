<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewListUrlController extends UrlController
{
    /**
     * Undocumented function
     * @inheritDoc
     * @throws Undocumented function
     */
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
