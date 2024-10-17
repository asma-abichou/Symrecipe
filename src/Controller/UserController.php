<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/edit/{id}', name: 'edit.user')]
    public function editProfile(User $user): Response
    {
        $user = new User();
        if(!$this->getUser()){
            $this->redirectToRoute('app_login');
        }
        if($this->getUser() !== $user){
            $this->redirectToRoute('recipe.list');
        }
        $form = $this->createForm(UserType::class, $user);
        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView()
        ]);


    }
}
