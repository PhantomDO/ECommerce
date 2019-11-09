<?php


namespace App\Controller;

use phpDocumentor\Reflection\DocBlock\Tags\Property;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class PropertyController extends AbstractController
{

    /**
     * @Route ("/biens")
     * @return Response
     */

    public function index() : Response
    {
        $property = new Property();
        $property->setTitle('Le premier bien des frate')
            ->setPrice(999)
            ->setDescription('oh putain frate le premier bien eh');
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }
}