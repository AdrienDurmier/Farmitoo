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
        // FIXME Pour le test je récupère directement l'unique commande
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
