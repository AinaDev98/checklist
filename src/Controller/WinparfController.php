<?php

namespace App\Controller;

use App\Entity\Winparf;
use App\Form\WinparfType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WinparfController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/winparf', name: 'app_winparf')]
    public function index(Request $request): Response
    {
        $addWinparf = new Winparf();
        $formWinparf = $this->createForm(WinparfType::class, $addWinparf);

        $formWinparf->handleRequest($request);
        if($formWinparf->isSubmitted() && $formWinparf->isValid())
        {
            $this->entityManager->persist($addWinparf);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_winparf');
        }
        return $this->render('interface_admin/winparf.html.twig', [
            'formWinparf' => $formWinparf->createView()
        ]);
    }

    #[Route('/admin/winparf/list', name: 'app_list_winparf')]
    public function read()
    {
        $readWinparf = $this->entityManager->getRepository(Winparf::class)->findAll();

        return $this->render('interface_admin/list_winparf.html.twig', [
            'readWinparf' => $readWinparf
        ]);
    }

    #[Route('/admin/winparf/list{id}', name: 'app_delete_winparf')]
    public function delete($id)
    {
        $deleteWinparf = $this->entityManager->getRepository(Winparf::class)->findOneById($id);
        if($deleteWinparf)
        {
            $this->entityManager->remove($deleteWinparf);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_winparf');
        }
    }
}
