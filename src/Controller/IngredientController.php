<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IngredientController extends AbstractController
{
    /**
     * This function display all ingredients
     * @param IngredientRepository $ingredient
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredient', name: 'ingredient', methods: ['GET'])]
    public function index(IngredientRepository $ingredient ,PaginatorInterface $paginator, Request $request): Response
    {
        $ingredient = $paginator->paginate(
            $ingredient->findAll(),
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );

        return $this->render('pages/ingredient/index.html.twig',[
            'ingredients' => $ingredient
        ]);
    }
    #[Route('/ingredient/new', name: 'ingredient.new', methods: ['GET', 'POST'])]
    public function Create(Request $request , EntityManagerInterface $manager): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);
        //dd($form->handleRequest($request));
        if($form->isSubmitted() && $form->isValid()){
            dd($form);
            $ingredient = $form ->getData();
            $manager->persist($ingredient);
            $manager->flush();

            $this->redirectToRoute('ingredient');
        }
        return $this->render('pages/ingredient/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
