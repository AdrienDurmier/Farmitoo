<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Promotion;
use App\Service\PromotionService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="checkout_cart")
     * @param ManagerRegistry $doctrine
     * @param PromotionService $promotionService
     * @return Response
     */
    public function index(ManagerRegistry $doctrine, PromotionService $promotionService): Response
    {
        // Jeu d'essai demandé:
        // $product1 = new Product('Cuve à gasoil', 250000, 'Farmitoo');
        // $product2 = new Product('Nettoyant pour cuve', 5000, 'Farmitoo');
        // $product3 = new Product('Piquet de clôture', 1000, 'Gallagher');
        // $promotion1 = new Promotion(50000, 8, false);
        // Je passe une commande avec
        // Cuve à gasoil x1
        // Nettoyant pour cuve x3
        // Piquet de clôture x5
        $orders = $doctrine->getRepository(Order::class)->findAll();
        $order = $orders[0];
        $promotionService->apply($order);

        return $this->render('checkout/cart.html.twig', [
            'order'      => $order
        ]);
    }

    /**
     * @Route("/checkout/address", name="checkout_address", methods="POST")
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @return Response
     */
    public function address(ManagerRegistry $doctrine, Request $request): Response
    {
        $datas = $request->request->all();
        $em = $doctrine->getManager();

        $order = $doctrine->getRepository(Order::class)->find($datas['order']);
        $order->setStep(Order::STEP_ADDRESS);
        $em->persist($order);
        $em->flush();

        return $this->render('checkout/address.html.twig', [
            'order' => $order,
        ]);
    }
}
