<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserPropertyController extends AbstractController
{
    private $repository;
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/user", name="user.property.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $properties = $this->repository->findAllByUser($this->getUser());
        return $this->render('user/property/index.html.twig', compact('properties'));
    }


    /**
     * @Route("/user/property/create", name="user.property.new")
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->getUser()->addProperty($property);

            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success','Créer avec succès');

            return $this->redirectToRoute('user.property.index');
        }

        return $this->render('user/property/new.html.twig', [
            'property'=>$property,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/user/property/{id}", name="user.property.edit",methods="GET|POST")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success','Modifié avec succès');
            return $this->redirectToRoute('user.property.index');
        }

        return $this->render('user/property/edit.html.twig', [
            'property'=>$property,
            'form'=>$form->createView()
        ]);

    }

    /**
     * @Route("/user/property/{id}", name="user.property.delete", methods="DELETE")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Property $property, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))){
             $this->getUser()->removeProperty($property);
             $this->em->remove($property);
             $this->em->flush();
            $this->addFlash('success','Supprimé avec succès');
        }
        return $this->redirectToRoute('user.property.index');
    }
}