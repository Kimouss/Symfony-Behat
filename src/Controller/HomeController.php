<?php

namespace App\Controller;

use App\Form\ProductType;
use App\Model\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/other', name: 'app_home_other')]
    public function other(): Response
    {
        return $this->render('home/other.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/form', name: 'app_home_form')]
    public function form(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('home/valid.html.twig', [
                'controller_name' => 'HomeController',
                'product' => $form->getData(),
            ]);
        }

        return $this->render('home/form.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form,
        ]);
    }
}
