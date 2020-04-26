<?php

namespace App\Controller;

use App\Entity\NewsComment;
use App\Form\NewsCommentSubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service;
use App\From;
class NewsController extends AbstractController
{
    /**
     * @Route("/blog/{page}", name="blog")
     */
    public function blog($page = 1, Service\EntityMGR $entityMGR)
    {
        $contents = $entityMGR->findByPage('App:NewsContent',$page,10);

        return $this->render('news/blog.html.twig', [
            'contents' => $contents,
            'top5' => $this->getDoctrine()->getRepository('App:NewsContent')->findtop(5)
        ]);
    }

    /**
     * @Route("/blog/{msg}/post/{url}", name="blogShowPost")
     */
    public function blogShowPost($msg=0,$url,Request $request, Service\EntityMGR $entityMGR)
    {
        $content = $this->getDoctrine()->getRepository('App:NewsContent')->findOneBy(['url'=>$url]);
        if(is_null($content))
            throw $this->createNotFoundException();
        $comment = new NewsComment();
        $comment->setPost($content);
        if(! is_null($this->getUser()))
            $comment->setUser($this->getUser());

        $form = $this->createForm(NewsCommentSubmitType::class,$comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setEmailMD5($comment->getEmail());
            $comment->setDateSubmit(time());
            $entityMGR->insertEntity($comment);
            return $this->redirectToRoute('blogShowPost',['url'=>$content->getUrl(), 'msg'=>1]);
        }
        return $this->render('news/blogPost.html.twig', [
            'content' => $content,
            'form'=>$form->createView()
        ]);
    }
}
