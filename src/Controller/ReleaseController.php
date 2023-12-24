<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ReleaseController extends AbstractController
{
    #[Route('/api/release', name:'app_product_release_reservation', methods: ['POST'])]
    public function releaseReservation(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $productRepository = $this->getDoctrine()->getRepository(Product::class);

        foreach($data['codes'] as $code) {
            $product= $productRepository->findOneBy(['code'=> $code]);

            if($product) {
                $product->setQuantity($product->getQuantity() + 1);
            } else {
                return $this->json(['error' => "Продукция по коду $code не найдена."], 404);
            }
        }
        $this->getDoctrine()->getManager()->flush();

        return $this->json(['message' => "Освобождение резервов успешно завершено"],200);
    }
}
