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
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }
    /**
     * This function display all ingredients
     * @param IngredientRepository $ingredient
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredient', name: 'ingredient.list', methods: ['GET'])]
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
    public function Create(Request $request): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //dd($form);
            $ingredient = $form->getData();
            //dd($ingredient);
            $this->entityManager->persist($ingredient);
            $this->entityManager->flush();
            $this->addFlash( 'success' , 'votre ingredient a ete bien créer');

          return $this->redirectToRoute('ingredient.list');
        }
        return $this->render('pages/ingredient/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/ingredient/edition/{id}', name: 'ingredient.edit', methods: ['GET','POST'])]
    public function edit(IngredientRepository $repository, $id, Request $request): Response
    {
        $ingredient = $repository->findOneBy(['id' => $id]);
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $ingredient = $form->getData();
            $this->entityManager->persist($ingredient);
            $this->entityManager->flush();
            $this->addFlash( 'success' , 'Votre ingredient a ete bien Modifier');

            return $this->redirectToRoute('ingredient.list');
        }

        return $this->render('pages/ingredient/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
