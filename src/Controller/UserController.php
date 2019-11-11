<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;


class UserController extends AbstractController
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function Register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // Creation user et son form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // Test d'envoie du form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // Encode le mot de passe
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // Update de la base avec le user précédement créé
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Renvoie la page
            return $this->redirectToRoute("user_registration");
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/update", name="user_update")
     * @param Request $request
     * @param Security $security
     */
    public function Update(Request $request, Security $security, UserPasswordEncoderInterface $passwordEncoder)
    {
        // Recup user et son form
        $user = $security->getUser();
        if (isset($user))
        {
            //dd($user);
            $form = $this->createForm(UserType::class, $user);
            // Test d'envoie du form
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                // Encode le mot de passe
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                // Update de la base avec le user précédement créé
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                // Renvoie la page
                return $this->redirectToRoute("user_update");
            }

            return $this->render(
                'user/update.html.twig',
                array('form' => $form->createView())
            );
        }
        else
            dump("null");
    }

    /**
     * @Route("/profile", name="user_profile")
     * @param Request $request
     * @param Security $security
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function Profile(Request $request, Security $security)
    {
        $user = $security->getUser();
        $message = null;

        if (isset($user))
            $message = "Hi " . $user->getUsername() . " !";
        else
            $message = "There is no one connected.";

        return $this->render(
            'user/show.html.twig', ['message' => $message, 'user' => $user]
        );
    }
}