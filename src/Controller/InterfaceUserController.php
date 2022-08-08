<?php

namespace App\Controller;

use App\Entity\InterfaceUser;
use App\Form\InterfaceUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InterfaceUserController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name:'app_interface_user')]
    public function index(Request $request): Response
    {
        $addCheck = new InterfaceUser();
        $formCheck = $this->createForm(InterfaceUserType::class, $addCheck);

        $formCheck->handleRequest($request);
        if($formCheck->isSubmitted() && $formCheck->isValid())
        {
            $this->entityManager->persist($addCheck);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_success');
        }

        return $this->render('interface_user/index.html.twig', [
            'formCheck' => $formCheck->createView()
        ]);
    }

    #[Route('/success', name:'app_success')]
    public function success()
    {
        return $this->render('interface_user/success.html.twig');
    }
}
