<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateNewUrlController extends UrlController
{
    /**
     * Undocumented function
     * @inheritDoc
     * @throws Undocumented function
     */
    #[Route('/', name: 'create_new_url', methods: ['POST'])]
    public function index(Request $payload): RedirectResponse
    {
        try {
            $url = $this->service->createNew(
                $this->createFormBuilder(),
                $payload
            );

            return $this->redirectToRoute(
                'public_view_shortened_url',
                [ 'url_tag' => $url ]
            );

        } catch (InvalidArgumentException $err) {
            $this->addFlash('error', $err->getMessage());

        } catch (UniqueConstraintViolationException $err) {
            return $this->redirectToRoute(
                'public_view_shortened_url',
                [ 
                    'url_tag' => $this->service->getTagByUrl(
                        $payload->request->all()['form']['url']
                    )
                ]
            );

        } catch (Exception $err) {
            $this->addFlash('error', 'Internal Server Error!');
            $this->logger->error($err);
            if ($this->getParameter('kernel.environment') === 'dev') {
                dd($err);
            }
        }

        return $this->redirectToRoute('public_home', []);
    }
}
