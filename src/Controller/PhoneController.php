<?php

namespace App\Controller;

use App\Entity\Telephone;
use App\Form\PhoneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhoneController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/phone', name: 'app_phone')]
    public function index(Request $request): Response
    {
        $addPhone = new Telephone();
        $formPhone = $this->createForm(PhoneType::class, $addPhone);

        $formPhone->handleRequest($request);
        if ($formPhone->isSubmitted() && $formPhone->isValid())
        {
            $this->entityManager->persist($addPhone);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_phone');
        }
        return $this->render('interface_admin/phone.html.twig', [
            'formPhone' => $formPhone->createView()
        ]);
    }

    #[Route('/admin/phone/list', name: 'app_list_phone')]
    public function read()
    {
        $readPhone = $this->entityManager->getRepository(Telephone::class)->findAll();

        return $this->render('interface_admin/list_phone.html.twig', [
            'readPhone' => $readPhone
        ]);
    }

    #[Route('/admin/phone/list/{id}', name: 'app_delete_phone')]
    public function delete($id)
    {
        $deletePhone = $this->entityManager->getRepository(Telephone::class)->findOneById($id);

        if ($deletePhone)
        {
            $this->entityManager->remove($deletePhone);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_phone');
        }
    }
}
