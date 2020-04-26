<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function homePage()
    {
        return $this->render('home/index.html.twig', [
            'blogLasts'=> $this->getDoctrine()->getRepository('App:NewsContent')->findtop(3)
        ]);
    }
    /**
     * @Route("/page/contact", name="pageContact")
     */
    public function pageContact()
    {
        return $this->render('home/contact.html.twig', [
        ]);
    }
    /**
     * @Route("/page/about", name="pageAbout")
     */
    public function pageAbout()
    {
        return $this->render('home/about.html.twig', [
        ]);
    }
    /**
     * @Route("/404", name="404")
     */
    public function error404()
    {
        return $this->render('home/404.html.twig', [
        ]);
    }
}
