<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service;
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
     * @Route("/blog/post/{url}", name="blogShowPost")
     */
    public function blogShowPost($url, Service\EntityMGR $entityMGR)
    {
        $content = $this->getDoctrine()->getRepository('App:NewsContent')->findOneBy(['url'=>$url]);
        if(is_null($content))
            throw $this->createNotFoundException();

        return $this->render('news/blogPost.html.twig', [
            'content' => $content,
        ]);
    }
}
