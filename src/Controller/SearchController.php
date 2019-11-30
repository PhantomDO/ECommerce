<?php


namespace App\Controller;

use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Form\PropertyType;
use App\Form\UserType;
use App\Entity\Property;

use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class SearchController extends AbstractController
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


}