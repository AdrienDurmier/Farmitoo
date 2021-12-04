<?php

namespace App\Controller;

use App\Entity\Item;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ItemController extends AbstractController
{
    /**
     * @Route("/item/{id}", name="item.edit", methods="POST")
     * @param int $id
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function edit(int $id, Request $request, ManagerRegistry $doctrine, SerializerInterface $serializer)
    {
        $datas = $request->request->all();
        $em = $doctrine->getManager();

        $item = $doctrine->getRepository(Item::class)->find($id);
        $item->setQuantity($datas['quantity']);
        $em->persist($item);
        $em->flush();

        $itemNormalize = $serializer->normalize($item, null, ['groups' => 'item:read']);

        return new JsonResponse($itemNormalize);
    }
}
