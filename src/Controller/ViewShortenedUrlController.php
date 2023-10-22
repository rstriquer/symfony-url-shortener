<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\UrlController;
use App\Entity\Url;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewShortenedUrlController extends UrlController
{
    /**
     * Undocumented function
     * @inheritDoc
     * @throws Undocumented function
     */
    #[Route('/{url_tag}/preview', name: 'public_view_shortened_url', methods: ['GET'])]
    public function index(Request $payload): Response
    {
        $result = [];
        try {
            $result = $this->service->view(
                $payload->attributes->get('url_tag')
            );
        } catch (EntityNotFoundException $err) {
            if ($this->getParameter('kernel.environment') === 'dev') {
                dd($err);
            }

            $this->logger->error($err);
            $this->addFlash('error', 'The TAG you tried does not existed!');
            return $this->redirectToRoute('public_home', []);

        } catch (Exception $err) {
            $this->logger->error($err);
            if ($this->getParameter('kernel.environment') === 'dev') {
                dd($err);
            }
        }

        return $this->render('preview_url/index.html.twig', $result);
        
    }
}
