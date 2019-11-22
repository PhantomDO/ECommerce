<?php


namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
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

    public function __construct(PropertyRepository $repository, ObjectManager $objectManager)
    {
        $this->repository = $repository;
        $this->entityManager = $objectManager;
    }

    /**
     * @Route ("/biens", name="property.index")
     * @return Response
     */
    public function index() : Response
    {
        /*$property = $this->repository->findAllVisible();
        dd($property);

        $property = new \App\Entity\Property();
        $property->setTitle('Le premier bien des frate')
            ->setPrice(999)
            ->setDescription('oh putain frate le premier bien eh')
            ->setCity('Lyon');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($property);
        $entityManager->flush();
        */

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
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