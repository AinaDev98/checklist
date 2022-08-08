<?php

namespace App\Controller;

use App\Entity\InterfaceUser;
use App\Controller\Search;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckListController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/checklist', name: 'app_checklist')]
    public function index(): Response
    {
        $listCheck = $this->entityManager->getRepository(InterfaceUser::class)->findAll();

        return $this->render('interface_admin/checklist.html.twig', [
            'listCheck' => $listCheck,
        ]);
    }
}
