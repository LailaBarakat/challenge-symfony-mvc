<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class LearningController extends AbstractController
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @Route("/learning", name="learning")
     */
    public function index(): Response
    {
        return $this->render('learning/index.html.twig', [
            'controller_name' => 'LearningController',
        ]);
    }

    /**
     * @Route("/about-becode", name="about-me")
     */
    public function aboutMe()
    {
        $name = 'unknown';
        if(!empty($this->session->get('name'))){
            $name = $this->session->get('name');
            return $this->render('learning/aboutMe.html.twig', ['name'=>$name]);
        }else
            {
                $response = $this->forward('App\Controller\LearningController::showMyName');
                    return $response;
        }

    }

    /**
     * @Route("/", name="homepage")
     * @Route("/showMyName", name="my-name")
     */
    public function showMyName(): Response
    {
        //$session = new Session();
        //$session->start();
        $name = 'unknown';
        if(!empty($this->session->get('name'))){
            $name = $this->session->get('name');
        }

        return $this->render('learning/showMyName.html.twig', ['name'=>$name]);
    }

    /**
     * @Route("/changeMyName", name="change", methods={"POST"})
     */
    public function changeMyName(): RedirectResponse
    {
        if(!empty($_POST['name'])){

            $name = $_POST['name'];
            $this->session->set('name',$name);
        }

        return $this->redirectToRoute("my-name");
    }
}
