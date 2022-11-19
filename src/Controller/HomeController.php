<?php

namespace App\Controller;

use App\Entity\CarSearch;
use App\Form\CarSearchType;
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function home(Request $request, CarRepository $carRepository): Response
    {
        $carSearch = new CarSearch();
        $cars = [];

        $form = $this->createForm(CarSearchType::class, $carSearch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $carSearch->getName();
            $cars = $carRepository->findBy(['name' => $name]);

            return $this->render('car/list.html.twig', [
                'form' => $form->createView(),
                'cars' => $cars
            ]);
        } else {
            return $this->render('home/homepage.html.twig', [
                'form' => $form->createView(),
                'controller_name' => 'HomeController',
            ]);
        }
    }
}
