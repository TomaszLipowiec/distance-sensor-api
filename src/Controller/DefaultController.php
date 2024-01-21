<?php

namespace App\Controller;

use DateTime;
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

    #[Route('/api/save/{dist}/{key}', name: 'distance-sensor-save', methods: ['GET'])]
    public function apiSave(EntityManagerInterface $entityManager, int $dist, string $key):  Response{

        if($key == "4a99c6e3-accc-465b-90bc-e6f3f3a892e8"){
            $distance = new Distance;

            $distance->setCm($dist);
            $distance->setDate(new DateTime('now'));

            $entityManager->persist($distance);
            $entityManager->flush();

            return new Response('200');
        } else {
            return new Response('503');
        }

    }
}