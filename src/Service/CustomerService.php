<?php

namespace App\Service;

use App\Entity\Customer;
use App\Service\UserGeneratorService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class CustomerService
{
    private $em;
    private $doctrine;
    private $userGeneratorService;

    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $em, UserGeneratorService $userGeneratorService) 
    {
        $this->em = $em;
        $this->doctrine = $doctrine->getManager();
        $this->userGeneratorService = $userGeneratorService;
    }

    public function create(Request $request): Customer
    {
        $parameters = json_decode($request->getContent(), true);
        $customer = new Customer();
        $customer->setFirstName($parameters['first_name']);
        $customer->setLastName($parameters['last_name']);
        $customer->setEmail($parameters['email']);
        $customer->setUsername($parameters['username']);
        $customer->setPassword($parameters['password']);
        $customer->setGender($parameters['gender']);
        $customer->setCountry($parameters['country']);
        $customer->setCity($parameters['city']);
        $customer->setPhone($parameters['phone']);

        $entityManager = $this->doctrine;
        $entityManager->persist($customer);
        $entityManager->flush();

        return $customer;
    }

    public function update(Request $request)
    {
        $parameters = json_decode($request->getContent(), true);
        $customer = new Customer();
        $customer->setFirstName($parameters['first_name']);
        $customer->setLastName($parameters['last_name']);
        $customer->setEmail($parameters['email']);
        $customer->setUsername($parameters['username']);
        $customer->setPassword($parameters['password']);
        $customer->setGender($parameters['gender']);
        $customer->setCountry($parameters['country']);
        $customer->setCity($parameters['city']);
        $customer->setPhone($parameters['phone']);

        $entityManager = $this->em->getRepository(Customer::class);
        $entityManager->merge($customer);
        $entityManager->flush();

        return $customer;
    }

    public function getAllCustomers(): array
    {
        $customerRepository = $this->em->getRepository(Customer::class);
        $customers = $customerRepository->findAll();
        return $customers;
    }

    public function getCustomerById(string $id)
    {
        if (!$id) return "Customer ID is required";
        $customerRepository = $this->em->getRepository(Customer::class);
        $customer = $customerRepository->findById($id);
        if (!$customer) return "Customer not found";
        return $customer;
    }

    public function generateRandomCustomersFromExternalAPI()
    {
        $customerRepository = $this->em->getRepository(Customer::class);

        $response = $this->userGeneratorService->getRandomUsersFromExternalAPI('AU', 'gender,name,nat,email,login,location,phone', '1', '100');

        $customers = array();

        foreach ($response['results'] as $data) {
            $exists = $customerRepository->findOneBySomeField($data['email']);

            $request = new Request();
            $content =  array(
                'first_name' => $data['name']['first'],
                'last_name' => $data['name']['last'],
                'email' => $data['email'],
                'username' => $data['login']['username'],
                'password' => md5($data['login']['password']),
                'gender' => $data['gender'],
                'country' => $data['location']['country'],
                'city' => $data['location']['city'],
                'phone' => $data['phone']
            );

            $request->initialize(content: json_encode($content, JSON_FORCE_OBJECT));

            if(!$exists) $this->create($request);
            else $this->update($request);
            $customers[] = json_decode($request->getContent(), true);
        }
        return $customers;
    }
}
