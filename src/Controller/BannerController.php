<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Knp\Component\Pager\PaginatorInterface;
use Siganushka\BannerBundle\Form\Type\BannerType;
use Siganushka\BannerBundle\Repository\BannerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BannerController extends AbstractFOSRestController
{
    protected BannerRepository $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function getCollection(Request $request, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $this->bannerRepository->createQueryBuilderWithSorted();

        $page = $request->query->getInt('page', 1);
        $size = $request->query->getInt('size', 10);

        $pagination = $paginator->paginate($queryBuilder, $page, $size);

        return $this->viewResponse($pagination);
    }

    public function postCollection(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entity = $this->bannerRepository->createNew();

        $form = $this->createForm(BannerType::class, $entity);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $this->viewResponse($form);
        }

        $entityManager->persist($entity);
        $entityManager->flush();

        return $this->viewResponse($entity);
    }

    public function getItem(int $id): Response
    {
        $entity = $this->bannerRepository->find($id);
        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Resource with value "%d" not found.', $id));
        }

        return $this->viewResponse($entity);
    }

    public function putItem(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $entity = $this->bannerRepository->find($id);
        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Resource with value "%d" not found.', $id));
        }

        $form = $this->createForm(BannerType::class, $entity);
        $form->submit($request->request->all(), !$request->isMethod('PATCH'));

        if (!$form->isValid()) {
            return $this->viewResponse($form);
        }

        $entityManager->flush();

        return $this->viewResponse($entity);
    }

    public function deleteItem(EntityManagerInterface $entityManager, int $id): Response
    {
        $entity = $this->bannerRepository->find($id);
        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Resource with value "%d" not found.', $id));
        }

        $entityManager->remove($entity);
        $entityManager->flush();

        // 204 no content response
        return $this->viewResponse(null, Response::HTTP_NO_CONTENT);
    }

    protected function viewResponse($data = null, int $statusCode = null, array $headers = []): Response
    {
        $context = new Context();
        $context->setGroups([
            'trait_resource', 'trait_sortable', 'trait_enable', 'trait_timestampable',
            'banner',
            'media',
        ]);

        $view = View::create($data, $statusCode, $headers);
        $view->setContext($context);

        return $this->getViewHandler()->handle($view);
    }
}
