<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class RecipeController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager){

    }
    #[Route('/recette', name: 'recipe.list', methods: ['GET'])]
    public function index(RecipeRepository $recipe , PaginatorInterface $paginator, Request $request): Response
    {

        $recipe = $paginator->paginate(
            $recipe->findAll(),
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );
        //dd('dd');
        return $this->render('pages/recipe/list.html.twig',[
            'recipes' => $recipe,
        ]);
    }

     #[Route('/recette/new', name: 'recipe.new', methods: ['GET', 'POST'])]
    public function Create(Request $request): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $recipe = $form->getData();
            $this->entityManager->persist($recipe);
            $this->entityManager->flush();
            $this->addFlash( 'success' , 'votre Recette a ete bien créer');

          return $this->redirectToRoute('recipe.list');
        }
        return $this->render('pages/recipe/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/recette/edition/{id}', name: 'recipe.edit', methods: ['GET','POST'])]
    public function edit(RecipeRepository $repository, $id, Request $request): Response
    {
        $recipe = $repository->findOneBy(['id' => $id]);
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $recipe = $form->getData();
            $this->entityManager->persist($recipe);
            $this->entityManager->flush();
            $this->addFlash( 'success' , 'Votre recette a ete bien Modifier');

            return $this->redirectToRoute('recipe.list');
        }

        return $this->render('pages/recipe/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
    #[Route('/recette/supression/{id}', name: 'recipe.delete', methods: ['GET'])]
    public function delete($id): Response
    {
        $recipe = $this->entityManager->getRepository(recipe::class)->find($id);

        if(!$recipe){
            $this->addFlash('danger', 'Pas recette trouver avec id ' . $id);
            return $this->redirectToRoute('recipe.list');
        }
        $this->entityManager->remove($recipe);
        $this->entityManager->flush();
        $this->addFlash("success", "Votre recette a ete bien Supprimer");
        return $this->redirectToRoute('recipe.list');
    }
}
