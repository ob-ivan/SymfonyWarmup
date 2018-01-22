<?php
namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @Route("/product/new", name="product")
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19.99);
        $product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Saved new product with id ' . $product->getId());
    }

    /**
     * @Route("/product/{idOrName}", name="product_show")
     */
    public function showAction($idOrName)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Product::class);
        $product = $repository->find($idOrName);

        if (!$product) {
            $product = $repository->findOneBy(['name' => $idOrName]);
            if (!$product) {
                throw $this->createNotFoundException(
                    'No product found for id or name ' . $idOrName
                );
            }
        }

        return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
