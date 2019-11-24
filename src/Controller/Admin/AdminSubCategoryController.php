<?php

namespace App\Controller\Admin;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/subcategory")
 */
class AdminSubCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin.subcategory.index", methods={"GET"})
     */
    public function index(SubCategoryRepository $subCategoryRepository): Response
    {
        return $this->render('admin/subcategory/index.html.twig', [
            'subcategories' => $subCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.subcategory.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $subcategory = new SubCategory();
        $form = $this->createForm(SubCategoryType::class, $subcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subcategory);
            $entityManager->flush();

            return $this->redirectToRoute('admin.subcategory.index');
        }

        return $this->render('admin/subcategory/new.html.twig', [
            'subcategory' => $subcategory,
            'form' => $form->createView(),
        ]);
    }

    /*
     * @Route("/{id}", name="sub_category_show", methods={"GET"})
     *
    public function show(SubCategory $subCategory): Response
    {
        return $this->render('admin/subcategory/show.html.twig', [
            'subcategory' => $subCategory,
        ]);
    }*/

    /**
     * @Route("/{id}/edit", name="admin.subcategory.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SubCategory $subcategory): Response
    {
        $form = $this->createForm(SubCategoryType::class, $subcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.subcategory.index');
        }

        return $this->render('admin/subcategory/edit.html.twig', [
            'subcategory' => $subcategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.subcategory.delete", methods={"DELETE"})
     */
    public function delete(Request $request, SubCategory $subcategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subcategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subcategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.subcategory.index');
    }
}
