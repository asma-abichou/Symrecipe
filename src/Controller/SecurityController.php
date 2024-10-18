<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function __construct(private  EntityManagerInterface $entityManager){

    }
    #[Route('/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('recipe.list');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }


    #[Route('/deconnexion', name: 'app_logout', methods:['GET'])]
    public function logout(): Response
    {
        return $this->render('security/login.html.twig');
    }

    #[Route('/inscription', name: 'security.register', methods:['POST','GET'])]
    public function Registration(Request $request): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash( 'success' ,
                'votre compte a bien été créer');

        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}
