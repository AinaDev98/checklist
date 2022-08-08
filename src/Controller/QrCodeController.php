<?php

namespace App\Controller;

use App\Entity\QrCode;
use App\Form\QrCodeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QrCodeController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/qr-code', name: 'app_qrcode')]
    public function index(Request $request): Response
    {
        $addQrCode = new QrCode();
        $formQrCode = $this->createForm(QrCodeType::class, $addQrCode);

        $formQrCode->handleRequest($request);
        if ($formQrCode->isSubmitted() && $formQrCode->isValid())
        {
            $this->entityManager->persist($addQrCode);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_qrcode');
        }
        return $this->render('interface_admin/qrCode.html.twig', [
            'formQrCode' => $formQrCode->createView()
        ]);
    }

    #[Route('/admin/qr-code/list', name: 'app_list_qrcode')]
    public function read()
    {
        $readQrCode = $this->entityManager->getRepository(QrCode::class)->findAll();

        return $this->render('interface_admin/list_qrcode.html.twig', [
            'readQrCode' => $readQrCode
        ]);
    }

    #[Route('/admin/qr-code/list/{id}', name: 'app_delete_qrcode')]
    public function delete($id)
    {
        $deleteQrCode = $this->entityManager->getRepository(QrCode::class)->findOneById($id);

        if ($deleteQrCode)
        {
            $this->entityManager->remove($deleteQrCode);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_qrcode');
        }
    }
}
