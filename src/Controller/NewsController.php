<?php

namespace App\Controller;

use App\Entity\NewsComment;
use App\Form\NewsCommentSubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
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
            'top5' => $this->getDoctrine()->getRepository('App:NewsContent')->findtop(5),
            'tags' => $this->getDoctrine()->getRepository('App:NewsTag')->topTags()
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
        $content->setViewCount($content->getViewCount() + 1 );
        $em = $this->getDoctrine()->getManager();
        $em->persist($content);
        $em->flush();
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
        elseif ($form->isSubmitted() && ! $form->isValid()) {
            return $this->redirectToRoute('blogShowPost',['url'=>$content->getUrl(), 'msg'=>2]);
        }
        return $this->render('news/blogPost.html.twig', [
            'content' => $content,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/cat/{url}/{page}", name="blogCat")
     */
    public function blogCat($url,$page = 1, Service\EntityMGR $entityMGR)
    {
        $cat = $this->getDoctrine()->getRepository('App:NewsCat')->findOneBy(['catUrl'=>$url]);
        if(is_null($cat))
            throw $this->createNotFoundException();
        $contents = $this->getDoctrine()->getRepository('App:NewsContent')->findByCat($cat,$page);

        return $this->render('news/blog.html.twig', [
            'contents' => $contents,
            'top5' => $this->getDoctrine()->getRepository('App:NewsContent')->findtop(5),
            'tags' => $this->getDoctrine()->getRepository('App:NewsTag')->topTags()
        ]);
    }

    /**
     * @Route("/tag/{tag}/{page}", name="blogTag")
     */
    public function blogTag($tag,$page = 1, Service\EntityMGR $entityMGR)
    {
        $contents = $this->getDoctrine()->getRepository('App:NewsContent')->findByTag($tag,$page);
        if(count($contents) == 0)
            throw $this->createNotFoundException();
        return $this->render('news/blog.html.twig', [
            'contents' => $contents,
            'top5' => $this->getDoctrine()->getRepository('App:NewsContent')->findtop(5),
            'tags' => $this->getDoctrine()->getRepository('App:NewsTag')->topTags()
        ]);
    }
}
