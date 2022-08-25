<?php

namespace App\Controller;

use App\Service\CustomerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends AbstractController
{
    private $customerService;
    private $userGeneratorService;

    public function __construct(CustomerService $customerService, ) 
    {
        $this->customerService = $customerService;
    }

    #[Route('/customers', name: 'customers')]
    public function getCustomers(): JsonResponse
    {
        $response = $this->customerService->getAllCustomers();
        return $this->json(['data' => $response]);
    }

    #[Route('/customers/{id}', name: 'customer_by_id', defaults: ['id' => ''], methods: 'GET')]
    public function getCustomerById($id): JsonResponse
    {
        $response = $this->customerService->getCustomerById($id);
        return $this->json(['data' => $response]);
    }

    #[Route('/generate-customers', name: 'generate_customers', methods: 'GET')]
    public function generateCustomers()
    {
        $response = $this->customerService->generateRandomCustomersFromExternalAPI();
        return new Response(json_encode($response));
    }

    // #[Route('/customer', name: 'create_customer', methods: 'POST')]
    // public function createCustomer(Request $request): Response
    // {
    //     $customer = $this->customerService->create($request);
    //     return new Response($customer);
    // }
}
