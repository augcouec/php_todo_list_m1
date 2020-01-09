<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestMongoController extends AbstractController
{
    /**
     * @Route("/mongoTest", methods={"GET"})
     */
    public function mongoTest(DocumentManager $dm)
    {
        $user = new User();
        $user->setFirstname("Vincent");
        $dm->persist($user);
        $dm->flush();
        return new JsonResponse(array('Status' => 'OK'));
    }
}