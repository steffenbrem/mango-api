<?php
/**
 * Created by PhpStorm.
 * User: Steffen
 * Date: 08/05/14
 * Time: 15:02
 */

namespace Mango\API\RestBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Mango\CoreDomain\Repository\ProductRepositoryInterface;
use Mango\CoreDomainBundle\Service\ProductService;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class Testing {
    protected $string = "abc";
    protected $int = 12;
    protected $array = array(1, 2, 3);
}

/**
 * Class ProductsController
 *
 * @package Mango\API\RestBundle\Controller
 */
class ProductsController extends RestController
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var ProductService
     */
    protected $productService;

    public function init()
    {
        $this->productRepository = $this->get('mango_core_domain.product_repository');
        $this->productService = $this->get('mango_core_domain.product_service');
    }

    /**
     * Get all products.
     *
     * @ApiDoc(
     *  section = "Products"
     * )
     * @param ParamFetcher $paramFetcher
     * @return mixed
     */
    public function getProductsAction(ParamFetcher $paramFetcher)
    {
        $products = $this->productRepository->findAll();

//        echo $products['0']->getWorkspace()->getName();
//        die;

        return array(
            'products' => $products
        );
    }

    /**
     * Create a new product.
     *
     * @ApiDoc(
     *  section = "Products",
     *  input = "Mango\CoreDomainBundle\Form\StoreProductType"
     * )
     * @param Request $request
     * @return array|\Symfony\Component\Form\FormInterface
     */
    public function postProductsAction(Request $request)
    {
        $form = $this->productService->create($request);

        if ($form->isValid()) {
            return array($form->getName() => $form->getData());
        }

        return $form;
    }

    public function newProductsAction(Request $request)
    {
        $form = $this->postProductsAction($request);
        return $this->generateNewView($form, 'post_products');
    }
}