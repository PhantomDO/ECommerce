<?php


namespace App\Controller;

use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    private $entityManager;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route ("/biens", name="property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request) : Response
    {
        $search = new PropertySearch();

        $form = $this->createForm(PropertySearchType::class, $search);
        // Test d'envoie du form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            // Renvoie la page
            //return $this->redirectToRoute("property.index");
        }

        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/biens/api", name="property.api")
     */
    public function api(PaginatorInterface $paginator, Request $request) : JsonResponse
    {
        $search = new PropertySearch();

        $form = $this->createForm(PropertySearchType::class, $search);
        // Test d'envoie du form
        $form->handleRequest($request);

        $properties = [];

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $properties = $this->repository->findAllVisibleQueryJSON($search);
            return new JsonResponse(['results' => $properties]);
        }

        $properties = $this->repository->findAllVisibleQueryJSON($search);
        return new JsonResponse(['results' => $properties]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param \App\Entity\Property $property
     * @return Response
     */
    public function show(\App\Entity\Property $property, string $slug) : Response
    {
        if ($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}