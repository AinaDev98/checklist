<?php

namespace App\Controller;

use App\Entity\Boutiques;
use App\Form\BoutiquesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiquesController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/boutiques', name: 'app_boutiques')]
    public function index(Request $request): Response
    {
        $addboutiques = new Boutiques();
        $formboutique = $this->createForm(BoutiquesType::class, $addboutiques);

        $formboutique->handleRequest($request);
        if ($formboutique->isSubmitted() && $formboutique->isValid())
        {
            $this->entityManager->persist($addboutiques);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_boutiques');
        }

        return $this->render('interface_admin/boutiques.html.twig', [
            'formBoutiques' => $formboutique->createView()
        ]);
    }

    #[Route('/admin/boutiques/list', name: 'app_list_boutiques')]
    public function Read()
    {
        $readBoutiques = $this->entityManager->getRepository(Boutiques::class)->findAll();

        return $this->render('interface_admin/list_boutiques.html.twig', [
            'Boutiques' => $readBoutiques
        ]);
    }

    #[Route('/admin/boutiques/delete/{id}', name: 'app_delete_boutiques')]
    public function delete($id)
    {
        $deleteboutiques = $this->entityManager->getRepository(Boutiques::class)->findOneById($id);

        if ($deleteboutiques)
        {
            $this->entityManager->remove($deleteboutiques);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_boutiques');
        }
    }
}
