<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Url as UrlEntity;
use App\Repository\UrlRepository;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class UrlService
{
    private UrlGeneratorInterface $router;
    private UrlRepository $repository;

    public function __construct(
        UrlRepository $repository,
        UrlGeneratorInterface $router
    )
    {
        $this->repository = $repository;
        $this->router = $router;
    }

    /**
     * Get the create new url form
     * @param \Symfony\Component\HttpFoundation\Request $payload
     */
    public function getForm(FormBuilderInterface $form, Request $payload = null): FormInterface
    {
        $result = $form->add(
                'url',
                null,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Enter a new URL to shorten',
                    ],
                    'constraints' => [
                        new NotBlank(message: 'You need to provide an URL.'),
                        new Url(message: 'The URL provided was invalid.'),
                    ],
                ]
            )
            ->getForm();

        if ($payload) {
            $result->handleRequest($payload);
        }

        return $result;
    }

    public function list(FormBuilderInterface $form, Request $payload = null): array
    {
        return [
            'form' => $this->getForm($form, $payload),
            'list' => $this->repository->findBy([], ['url' => 'asc']),
        ];
    }

    /**
     * Return template data to render "view" page template on controller
     * @param \App\Entity\Url $url
     */
    public function view(string $tag) : array
    {
        $record = $this->repository->findOneBy([ 'tag' => $tag ]);

        if (!$record) {
            throw new EntityNotFoundException();
        }

        return [
            'url' => $record->getUrl(),
            'tag_local' => $this->router->generate(
                'public_redirect_shortened_url', 
                [ 'url_tag' => $record->getTag() ]
            ),
            'tag_full' => $this->router->generate(
                'public_redirect_shortened_url', 
                [ 'url_tag' => $record->getTag() ],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
        ];
    }

    public function redirect(string $tag) : string
    {
        $record = $this->repository->findOneBy([ 'tag' => $tag ]);

        if (!$record) {
            throw new EntityNotFoundException();
        }

        return $record->getUrl();
    }

    public function getTagByUrl(string $tag) : string
    {
        $record = $this->repository->findOneBy([ 'url' => $tag ]);

        if (!$record) {
            throw new EntityNotFoundException();
        }

        return $record->getTag();
    }

    /**
     * Create a record on urls tables
     * @param \Symfony\Component\Form\FormBuilderInterface $form
     * @param \Symfony\Component\HttpFoundation\Request|null $payload
     * @throws Exception When a record already exists
     */
    public function createNew(
        FormBuilderInterface $form,
        Request $payload = null
    ) : string
    {
        $form = $this->getForm($form, $payload);

        if (!$form->isSubmitted() || !$form->isValid()) {
            throw new InvalidArgumentException(
                // throw the first error as the message
                $form->getErrors(true, true)->current()->getMessage()
            );
        }

        $exists = $this->repository->findOneBy([
            'url' => $form->get('url')->getData()
        ]);

        $url = new UrlEntity();
        $url->setUrl($form->get('url')->getData());
        $url->setTag($this->repository->getNewUniqueTag($exists?->getTag()));
        $this->repository->flush($url);


        return $url->getTag();
    }
}

