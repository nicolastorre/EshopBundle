<?php

namespace Nicolas\EshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Nicolas\EshopBundle\Entity\Product;
use Nicolas\BlogBundle\Entity\Image;

use Nicolas\EshopBundle\Form\Type\ProductType;

class ProductController extends DefaultController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $productRepository = $em->getRepository('NicolasEshopBundle:Product');
        $products = $productRepository->findPublishedAndOrdered();

        return $this->render('NicolasEshopBundle:Product:index.html.twig', array(
            'title' => 'Products',
            'products' => $products,
            'total_products' => (int) $productRepository->countAllPublished()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $productRepository = $em->getRepository('NicolasEshopBundle:Product');
        $products = $productRepository->findAll();

        return $this->render('NicolasEshopBundle:Product:list.html.twig', array(
            'title' => 'Products',
            'products' => $products,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addAction(Request $request) {

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $product = new Product();
        $product->setUser($user);

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Perform some action, such as sending an email
            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();
            
            $this->zoomCrop($product);

            // Redirect - This is important to prevent users re-posting
            // the form if they refresh the page
            return $this->redirect($this->generateUrl('nicolas_eshop_product_list'));
        }


        return $this->render('NicolasEshopBundle:Product:add.html.twig', array(
            'title' => 'Add product',
            'form' => $form->createView()
        ));

    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Product $product) {

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            $this->zoomCrop($product);

            return $this->redirect($this->generateUrl('nicolas_eshop_product_list'));
        }
        return $this->render('NicolasEshopBundle:Product:add.html.twig', array(
                'title' => 'Edit product',
                'form' => $form->createView())
        );

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, Product $product) {

        $em = $this->getDoctrine()->getManager();

        if (!$product || (!$product->getPublished() && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))) {
            throw $this->createNotFoundException('article not found!');
        }

        return $this->render('NicolasEshopBundle:Product:show.html.twig', array(
            'title' => 'Products',
            'product' => $product
        ));
    }

    /**
     * @param Request $request
     */
    public function deleteAction(Request $request) {

        $deleteForm = $this->deleteForm('nicolas_eshop_product_delete');
        $deleteForm->handleRequest($request);
        if ($deleteForm->isValid()) {
            $data = $deleteForm->getData();

            $em = $this->getDoctrine()->getManager();
            $productRepository = $em->getRepository('NicolasEshopBundle:Product');
            $product = $productRepository->findOneById($data['id']);

            if (!$product) {
                throw $this->createNotFoundException('product not found!');
            }

            $em->remove($product);
            $em->flush();

            return $this->redirect($this->generateUrl('nicolas_eshop_product_list'));
        } else {
            return $this->redirect($this->generateUrl('nicolas_eshop_product_list'));
        }
    }
}
