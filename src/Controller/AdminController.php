<?php

namespace App\Controller;

use App\Entity;
use App\Form;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="adminDashboard")
     */
    public function adminDashboard()
    {
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/news/add", name="adminNewsAdd")
     */
    public function adminNewsAdd(Request $request)
    {
        $news = new Entity\NewsContent();
        $form = $this->createForm(Form\AdminNewsType::class,$news);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $news->setDateSubmit(time());
            $news->setCanComment(true);
            $news->setSubmitter($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();
        }
        return $this->render('admin/news/addNews.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
