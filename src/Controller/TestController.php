<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        //Model
        $users = ['test', 'test2'];

        //
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'users'           => $users
        ]);
    }

    /**
     * @Route("/user/simon", name="test_with_name")
     */
    public function index3()
    {
        dump('route2');die;
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
 /**
 * @Route("/user/{name}", name="test_with_name")
 */
    public function index2($name)
    {
        dump('route1');die;
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }



}
