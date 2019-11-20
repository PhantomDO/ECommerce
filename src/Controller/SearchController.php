<?php


namespace App\Controller;

use App\Form\PropertyType;
use App\Form\UserType;
use App\Entity\Property;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class SearchController extends AbstractController
{
    /**
     * @Route("/search_api", name="search_api")
     */
    public function SearchApi(Request $request)
    {
        // Recup property de recherche et son form
        $property = new Property();

        //dd($user);
        $form = $this->createForm(PropertyType::class, $property);
        // Test d'envoie du form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $data = [
                'title' => $form->get('title')->getData(),
                'price' => $form->get('price')->getData(),
                'city' => $form->get('city')->getData(),
            ];

            return new JsonResponse($data);
            // Renvoie la page
            //return $this->redirectToRoute("search_api");
        }

        return $this->render(
            'search/search.html.twig',
            array('form' => $form->createView())
        );
    }
}