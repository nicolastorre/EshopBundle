<?php

namespace Nicolas\EshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Nicolas\EshopBundle\Entity\Product;

class BasketController extends DefaultController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {

        $session = $request->getSession();
        if(!$session->has('basket'))
        {
            $session->set('basket', array());
        }

        $basket = $session->get('basket');
        $contents = array();

        if(!empty($basket)) {
            $em = $this->getDoctrine()->getManager();
            $productRepository = $em->getRepository('NicolasEshopBundle:Product');

            foreach($basket as $content) {
                $contents[] = array(
                    'product' => $productRepository->findOneById($content['id']),
                    'qte' => $basket[$content['id']]['qte']
                );

            }
        }

        return $this->render('NicolasEshopBundle:Basket:list.html.twig', array(
            'title' => 'Basket',
            'contents' => $contents,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addAction(Request $request, Product $product) {

        $session = $request->getSession();
        if(!$session->has('basket'))
        {
            $session->set('basket', array());
        }

        $basket = $session->get('basket');
        $id = $product->getId();

        if(isset($basket[$id])) {
            $qte = (int) $basket[$id]['qte'] + 1;
        } else {
            $qte = 1;
        }
        $basket[$id] = array('id' => $id, 'qte' => $qte);

        $session->set('basket', $basket);

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Ce produit a bien été ajouté de votre panier!');

        return $this->redirect($this->generateUrl('nicolas_eshop_basket_list'));


    }

    /**
     * @param Request $request
     */
    public function deleteAction(Request $request, Product $product) {

        $error = false;
        $session = $request->getSession();

        if(!$session->has('basket'))
        {
            $request->getSession()
                ->getFlashBag()
                ->add('alert', 'Votre panier est déjà vide!');

            $error = true;
        }

        $basket = $session->get('basket');
        $id = $product->getId();

        if(!isset($basket[$id])) {
            $request->getSession()
                ->getFlashBag()
                ->add('alert', "Ce produit n'est pas présent dans votre panier!");

            $error = true;
        }

        if(!$error) {
            if ($basket[$id]['qte'] > 1) {
                $qte = (int)$basket[$id]['qte'] - 1;
                $basket[$id] = array('id' => $id, 'qte' => $qte);

            } else {
                unset($basket[$id]);
            }
            $session->set('basket', $basket);

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Ce produit a bien été retiré de votre panier!');
        }

        return $this->redirect($this->generateUrl('nicolas_eshop_basket_list'));


    }
}
