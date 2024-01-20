<?php

namespace App\Controller;

use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Distance;

class DefaultController extends AbstractController{
    #[Route('/distance-sensor', name: 'distance-sensor-list', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response{

        $distances = $entityManager->getRepository(Distance::class)->findAll();

        return $this->render('distance/list.html.twig', ['distances' => $distances]);
    }

    #[Route('/api/save/{dist}', name: 'distance-sensor-save', methods: ['GET'])]
    public function apiSave(Request $request, EntityManagerInterface $entityManager):  Response{
        $dist = $request->get('dist');

        $distance = new Distance;

        $distance->setCm($dist);
        $distance->setDate(new DateTime('now'));

        $entityManager->persist($distance);
        $entityManager->flush();

        return new Response('200');
    }
}