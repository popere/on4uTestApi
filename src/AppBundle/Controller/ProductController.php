<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Product;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class ProductController extends FOSRestController
{

    /**
    * @Rest\Get(path = "/products", name="app_products_list")
    * @Rest\View
    */
    public function listAction()
    {
      $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findAll();
      return $products;
    }

    /**
    * @Rest\Get(
    *     path = "/products/{id}",
    *     name = "app_product_show",
    *     requirements = {"id"="\d+"}
    * )
    * @Rest\View
    */
    public function showAction(Product $product)
    {
      return $product;
    }

    /**
    * @Rest\Post(
    *    path = "/products",
    *    name = "app_product_create"
    * )
    * @Rest\View(StatusCode = 201)
    * @ParamConverter("product", converter="fos_rest.request_body")
    */
    public function createAction(Product $product)
    {
      $em = $this->getDoctrine()->getManager();

      $em->persist($product);
      $em->flush();

       return $this->view($product, Response::HTTP_CREATED,
                          ['Location' => $this->generateUrl('app_product_show',
                                        ['id' => $product->getId(),
                                        UrlGeneratorInterface::ABSOLUTE_URL])]);
    }


    /**
    * @Rest\Put(
    *    path = "/products/{id}",
    *    name = "app_product_edit",
    *    requirements = {"id"="\d+"}
    * )
    * @Rest\View(StatusCode = 201)
    * @ParamConverter("product", converter="fos_rest.request_body")
    */
    public function editAction(Product $product)
    {
      // $em = $this->getDoctrine()->getManager();
      //
      // $em->remove($product);
      // $em->flush();

      return $product->getId();

    }

    /**
    * @Rest\Delete(
    *    path = "/products/{id}",
    *    name = "app_product_remove",
    *    requirements = {"id"="\d+"}
    * )
    * @Rest\View(StatusCode = 204)
    */
    public function removeAction(Product $product)
    {
      $em = $this->getDoctrine()->getManager();

      $em->remove($product);
      $em->flush();

      return;
    }




}
