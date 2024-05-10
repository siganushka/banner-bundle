<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Siganushka\BannerBundle\Form\BannerType;
use Siganushka\BannerBundle\Repository\BannerRepository;
use Siganushka\GenericBundle\Exception\FormErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BannerController extends AbstractController
{
    protected SerializerInterface $serializer;
    protected BannerRepository $bannerRepository;

    public function __construct(SerializerInterface $serializer, BannerRepository $bannerRepository)
    {
        $this->serializer = $serializer;
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * @Route("/banners", methods={"GET"})
     */
    public function getCollection(Request $request, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $this->bannerRepository->createQueryBuilder('b');

        $page = $request->query->getInt('page', 1);
        $size = $request->query->getInt('size', 10);

        $pagination = $paginator->paginate($queryBuilder, $page, $size);

        return $this->createResponse($pagination);
    }

    /**
     * @Route("/banners", methods={"POST"})
     */
    public function postCollection(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entity = $this->bannerRepository->createNew();

        $form = $this->createForm(BannerType::class, $entity);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            throw new FormErrorException($form);
        }

        $entityManager->persist($entity);
        $entityManager->flush();

        return $this->createResponse($entity);
    }

    /**
     * @Route("/banners/{id<\d+>}", methods={"GET"})
     */
    public function getItem(int $id): Response
    {
        $entity = $this->bannerRepository->find($id);
        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Resource #%d not found.', $id));
        }

        return $this->createResponse($entity);
    }

    /**
     * @Route("/banners/{id<\d+>}", methods={"PUT", "PATCH"})
     */
    public function putItem(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $entity = $this->bannerRepository->find($id);
        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Resource #%d not found.', $id));
        }

        $form = $this->createForm(BannerType::class, $entity);
        $form->submit($request->request->all(), !$request->isMethod('PATCH'));

        if (!$form->isValid()) {
            throw new FormErrorException($form);
        }

        $entityManager->flush();

        return $this->createResponse($entity);
    }

    /**
     * @Route("/banners/{id<\d+>}", methods={"DELETE"})
     */
    public function deleteItem(EntityManagerInterface $entityManager, int $id): Response
    {
        $entity = $this->bannerRepository->find($id);
        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Resource #%d not found.', $id));
        }

        $entityManager->remove($entity);
        $entityManager->flush();

        // 204 no content response
        return $this->createResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param mixed $data
     */
    protected function createResponse($data = null, int $statusCode = Response::HTTP_OK, array $headers = []): Response
    {
        $attributes = ['id', 'title', 'img', 'sort', 'enabled', 'updatedAt', 'createdAt'];
        $json = $this->serializer->serialize($data, 'json', compact('attributes'));

        return JsonResponse::fromJsonString($json, $statusCode, $headers);
    }
}
