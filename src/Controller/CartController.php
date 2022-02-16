<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cart;
use App\Entity\Article;
use App\Form\CartType;
use Symfony\Component\HttpFoundation\Request;


class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function createCart($id)
    // : Response
    {
        // $genus = new Genus();
        // $genus->setName('Octopus'.rand(1, 100));
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($genus);
        // $em->flush();

        $cart = new Cart();
        $article = $this->getDoctrine()->getRepository('App\Entity\Article')->find($id);
        $cart->setTitle($article->getTitle());
        $cart->setMarketName($article->getAuthor());
        $cart->setDescription($article->getBody());
        $em = $this->getDoctrine()->getManager();
        $em->persist($cart);
        $em->flush();

       return $this->redirect('/show-articles');
        
    }

    public function showCarts(){
        $carts = $this->getDoctrine()->getRepository('App\Entity\Cart')->findAll();

        return $this->render('cart/index.html.twig',array('carts' => $carts));
    }
    public function deleteCart($id){
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('App\Entity\Cart')->find($id);

        if(!$cart){
            throw $this->createNotFoundException('There are no articles with the following id : '.$id);
        }

        $em->remove($cart);
        $em->flush();
        return $this->redirect('/show-carts');
    }
}
