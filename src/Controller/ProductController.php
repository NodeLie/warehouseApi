<?php

namespace App\Controller;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/api/product', name:'app_product_create', methods: ['POST'])]
    public function createProduct(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);

        $product = $this->getDoctrine()->getRepository(Product::class)->findOneBy(['uniqueCode' => $data['uniqueCode']]);

        if (isset($product)) {
            $product->setQuantity($product->getQuantity() + $data['quantity']);
        } else {
            $product = new Product();
            $product->setName($data['name']);
            $product->setSize($data['size']);
            $product->setUniqueCode($data['uniqueCode']);
            $product->setQuantity($data['quantity']);
        }
        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->json([
            'id'=> $product->getId(),
            'name'=> $product->getName(),
            'size'=> $product->getSize(),
            'uniqueCode'=> $product->getUniqueCode(),
            'quantity'=> $product->getQuantity(),
        ], 201);
    }
    #[Route('/api/product', name:'app_product_get', methods: ['GET'])]
    public function getProduct(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        
        return $this->json($data, 200);
    }

}
