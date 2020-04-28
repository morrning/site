<?php

namespace App\Controller;

use App\Entity;
use App\Form;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

                //add tags
                $tags = explode(',',$news->getKywords());

                foreach ($tags as $tag){
                    $en = $this->getDoctrine()->getRepository('App:NewsTag')->findOneBy(['tagName'=>$tag]);
                    $em = $this->getDoctrine()->getManager();
                    if(is_null($en)){
                        $en = new Entity\NewsTag();
                        $en->setTagName($tag);
                        $en->setTagUseCount(1);
                    }
                    else{
                        $en->setTagUseCount($en->getTagUseCount() + 1);
                    }
                    $news->addTag($en);
                    $em->persist($en);
                    $em->flush();
                }
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
     * @Route("/admin/news/archive/{msg}", name="adminNewsArchive", options={"expose"=true})
     */
    public function adminNewsArchive($msg = 0)
    {
        $news = $this->getDoctrine()->getRepository('App:NewsContent')->findAllSorted();
        return $this->render('admin/news/contentArchive.html.twig', [
            'contents' => $news,
        ]);
    }
    /**
     * @Route("/admin/news/delete/{id}", name="adminNewsContentDelete", options = { "expose" = true })
     */
    public function adminNewsContentDelete($id)
    {
        $news = $this->getDoctrine()->getRepository('App:NewsContent')->find($id);
        if(! is_null($news)){
            $em = $this->getDoctrine()->getManager();
            $em->remove($news);
            $em->flush();
        }
        return new Response('ok');
    }

    /**
     * @Route("/admin/comments/archive/{msg}", name="adminCommentsArchive", options={"expose"=true})
     */
    public function adminCommentsArchive($msg = 0)
    {
        $comments = $this->getDoctrine()->getRepository('App:NewsComment')->findAll();
        return $this->render('admin/news/commentArchive.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/admin/comments/delete/{id}", name="adminNewsCommentDelete", options = { "expose" = true })
     */
    public function adminNewsCommentDelete($id)
    {
        $comment = $this->getDoctrine()->getRepository('App:NewsComment')->find($id);
        if(! is_null($comment)){
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }
        return new Response('ok');
    }

    /**
     * @Route("/admin/cats/archive/{msg}", name="adminNewsCatArchive", options={"expose"=true})
     */
    public function adminNewsCatArchive($msg = 0)
    {
        $cats = $this->getDoctrine()->getRepository('App:NewsCat')->findAll();
        return $this->render('admin/news/catArchive.html.twig', [
            'cats' => $cats,
        ]);
    }

}
