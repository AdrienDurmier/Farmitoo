<?php

namespace App\Controller;

use App\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends AbstractController
{
    /**
     * @Route("/item", name="item.new", methods="POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function new(Request $request)
    {
        $datas = $request->request->all();
        $em = $this->getDoctrine()->getManager();

        $item = new Item();
        $item->setProduct($datas['product']);
        $item->setQuantity($datas['quantity']);
        $em->persist($item);
        $em->flush();

        return new JsonResponse($item);
    }
}
