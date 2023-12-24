<?php

namespace App\Controller;

use App\Entity\Warehouse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WarehouseController extends AbstractController
{
    #[Route('/api/warehouse', methods: ['POST'])]
    public function createWarehouse(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true); 

        $warehouse = new Warehouse();
        $warehouse->setName($data['name']);
        $warehouse->setAvailability($data['availability']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($warehouse);
        $entityManager->flush();

        return $this->json([
            'id' => $warehouse->getId(),
            'name' => $warehouse->getName(),
            'availability' => $warehouse->isAvailability(),
        ], 201);
    }

}
