<?php

namespace App\Controller;

use App\Repository\IngredientRepository;


use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'app_ingredient')]
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
}
