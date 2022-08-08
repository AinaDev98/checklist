<?php

namespace App\Controller;

use App\Entity\Cloud;
use App\Form\CloudType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CloudController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/cloud', name: 'app_cloud')]
    public function index(Request $request): Response
    {
        $addCloud = new Cloud();
        $formCloud = $this->createForm(CloudType::class, $addCloud);

        $formCloud->handleRequest($request);
        if ($formCloud->isSubmitted() && $formCloud->isValid())
        {
            $this->entityManager->persist($addCloud);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_cloud');
        }
        return $this->render('interface_admin/cloud.html.twig', [
            'formCloud' => $formCloud->createView()
        ]);
    }

    #[Route('/admin/cloud/list', name: 'app_list_cloud')]
    public function read()
    {
        $readCloud = $this->entityManager->getRepository(Cloud::class)->findAll();

        return $this->render('interface_admin/list_cloud.html.twig', [
            'readCloud' => $readCloud
        ]);
    }

    #[Route('/admin/cloud/list/{id}', name: 'app_delete_cloud')]
    public function delete($id)
    {
        $deleteCloud = $this->entityManager->getRepository(Cloud::class)->findOneById($id);

        if ($deleteCloud)
        {
            $this->entityManager->remove($deleteCloud);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_cloud');
        }
    }
}
