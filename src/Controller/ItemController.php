<?php

namespace App\Controller;

use App\Entity\Item;
use App\Service\PromotionService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ItemController extends AbstractController
{
    /**
     * @Route("/item/{id}", name="item.edit", methods="POST")
     * @param int $id
     * @param PromotionService $promotionService
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function edit(int $id, PromotionService $promotionService, Request $request, ManagerRegistry $doctrine, SerializerInterface $serializer)
    {
        $datas = $request->request->all();
        $em = $doctrine->getManager();

        $item = $doctrine->getRepository(Item::class)->find($id);
        $item->setQuantity($datas['quantity']);
        $em->persist($item);
        $em->flush();

        // Mise à jour de la commande avec les promotions éventuelles
        $order = $item->getOrder();
        $promotionService->apply($order);

        $itemNormalize = $serializer->normalize($item, null, ['groups' => 'item:read']);

        return new JsonResponse($itemNormalize);
    }

    /**
     * @Route("/item/{id}", name="item.delete", methods="DELETE")
     * @param int $id
     * @param PromotionService $promotionService
     * @param ManagerRegistry $doctrine
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function delete(int $id, PromotionService $promotionService, ManagerRegistry $doctrine, SerializerInterface $serializer)
    {
        $em = $doctrine->getManager();
        $item = $doctrine->getRepository(Item::class)->find($id);
        $order = $item->getOrder();
        $em->remove($item);
        $em->flush();

        // Mise à jour de la commande avec les promotions éventuelles
        $promotionService->apply($order);

        $orderNormalize = $serializer->normalize($order, null, ['groups' => 'order:read']);

        return new JsonResponse($orderNormalize);
    }
}
