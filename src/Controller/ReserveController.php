<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ReserveController extends AbstractController
{
    #[Route('/api/reserve', name:'app_product_reservation', methods: ['POST'])]
    public function reserveProduct(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $productRepository = $this->getDoctrine()->getRepository(Product::class);

        foreach ($data['codes'] as $code) {
            $product = $productRepository->findOneBy(['code'=> $code]);

            if ($product && $product->getQuantity>0) {
                $product->setQuantity($product->setQuantity() - 1);
            } else {
                return $this->json(['error' => "Продукция по коду $code не подлежит резервированию."], 400);
            }
        }
        $this->getDoctrine()->getManager()->flush();

        return $this->json(["message"=> "Продукция зарезервирована."],200);
    }
}
