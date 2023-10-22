<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controls redirecting client to final destination
 */
class RedirectUrlController extends UrlController
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    #[Route('/{url_tag}', name: 'public_redirect_shortened_url', methods: ['GET'])]
    public function index(Request $payload): RedirectResponse
    {
        try {
            return $this->redirect($this->service->redirect(
                $payload->attributes->get('url_tag')
            ));

        } catch (EntityNotFoundException $err) {
            if ($this->getParameter('kernel.environment') === 'dev') {
                dd($err);
            }
            $this->logger->error($err);
            $this->addFlash('error', 'The TAG you tried does not existed!');
            return $this->redirectToRoute('public_home', []);

        } catch (Exception $err) {
            if ($this->getParameter('kernel.environment') === 'dev') {
                dd($err);
            }
            $this->addFlash('error', 'Internal Server Error!');
            $this->logger->error($err);
        }

        return $this->redirectToRoute('public_home', []);

    }
}
