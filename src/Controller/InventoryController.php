<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class InventoryController extends AbstractController
{
    #[Route('/api/inventory/{warehouseId}', methods: ['GET'])]
    public function getInventory(int $warehouseId): JsonResponse
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findOneBy(['warehouse'=> $warehouseId]);

        $result = [];

        foreach ($products as $product) {
            $result[] = [
                'id' => $product->getId(),
                'name'=> $product->getName(),
                'size'=> $product->getSize(),
                'code'=> $product->getCode(),
                'quantity'=> $product->getQuantity(),
            ];
        }
        return $this->json(['products' => $result]);
    }
}
