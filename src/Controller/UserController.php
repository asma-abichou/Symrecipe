<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    #[Route('/edit/{id}', name: 'edit.user')]
    public function editProfile(Security $security, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $security->getUser();
        if(!$this->getUser()){
            $this->redirectToRoute('app_login');
        }
        if($this->getUser() !== $user)
        {
            $this->redirectToRoute('recipe.list');
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $form->getData();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash( 'success' ,
                'votre compte a bien été Modifier');

            return $this->redirectToRoute('recipe.list');

        }
        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
