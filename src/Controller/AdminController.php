<?php

namespace App\Controller;

use App\Entity;
use App\Form;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AdminController extends AbstractController
{
    /**
     * function to generate random strings
     * @param 		int 	$length 	number of characters in the generated string
     * @return 		string	a new string is created with random characters of the desired length
     */
    private function RandomString($length = 32) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

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
        $file = $form->get('pictureBanner')->getData();
        $guid = $this->RandomString(32);
        if ($form->isSubmitted() && $form->isValid()) {
            if( is_null($file) || $file->getClientOriginalExtension() == 'gif'  || $file->getClientOriginalExtension() == 'jpg' || $file->getClientOriginalExtension() == 'jpeg' || $file->getClientOriginalExtension() == 'png'){
                $news->setPictureBanner(null);
                if(!is_null($file)){
                    $tempFileName = $guid . '.' . $file->getClientOriginalExtension();
                    $file->move(str_replace('src','public_html',dirname(__DIR__)) . '/publicFiles',$tempFileName );
                    $news->setPictureBanner($tempFileName);
                }
                if(trim($news->getUrl() == '')){
                    $news->setUrl(GoogleTranslate::trans($news->getTitle(), 'en', 'fa'));
                    if(! is_null($this->getDoctrine()->getRepository('App:NewsContent')->findOneBy(['url'=>$news->getUrl()])))
                        $news->setUrl($news->getUrl() . $this->RandomString(10));
                }
                $news->setDateSubmit(time());
                $news->setCanComment(true);
                $news->setViewCount(0);
                $news->setSubmitter($this->getUser());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($news);
                $entityManager->flush();
                return $this->redirectToRoute('adminNewsArchive',['msg'=>1]);
            }
            else{
                $form->addError(new FormError('نوع فایل وارد شده صحیح نیست.لطفا فایل ,png,gif,jpeg  ارسال فرمایید.'));
            }
        }
        return $this->render('admin/news/addNews.html.twig', [
            'form'=>$form->createView(),
            'alert'
        ]);
    }
    /**
     * @Route("/admin/news/archive/{msg}", name="adminNewsArchive")
     */
    public function adminNewsArchive($msg = 0)
    {
        $news = $this->getDoctrine()->getRepository('App:NewsContent')->findAll();
        return $this->render('admin/news/contentArchive.html.twig', [
            'contents' => $news,
        ]);
    }
}
