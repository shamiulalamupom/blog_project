<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\CatagoryRepository;
use App\Entity\Catagory;

final class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CatagoryRepository $catagoryRepository): Response
    {
        $catagories = $catagoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'catagories' => $catagories,
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_show')]
    public function show(Catagory $catagory): Response
    {
        return $this->render('category/show.html.twig', [
            'controller_name' => 'CategoryController',
            'catagory' => $catagory,
        ]);
    }
}
