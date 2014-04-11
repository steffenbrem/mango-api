<?php
/**
 * Created by PhpStorm.
 * User: Robinskoe
 * Date: 09/04/14
 * Time: 16:09
 */

namespace Mango\API\RestBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface;
use Mango\API\RestBundle\Component\ActionHandler\ActionHandlerInterface;
use Mango\API\RestBundle\Component\ActionHandler\Data\ResultFetcherInterface;
use Mango\API\RestBundle\Component\ActionHandler\Query\ParamQueryExtractor;
use Mango\API\RestBundle\Component\ActionHandler\Query\Query;
use FOS\RestBundle\Controller\Annotations as Rest;
use Mango\API\RestBundle\Request\ParamFetcher\QueryExtractor;
use Mango\CoreDomain\Model\Company;
use Mango\CoreDomain\Repository\CompanyRepositoryInterface;
//use Mango\CoreDomainBundle\Form\CompanyType;
use Mango\CoreDomainBundle\Form\UserType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class CompaniesController
 * @package Mango\API\RestBundle\Controller
 */
class CompaniesController extends RestController
{
    /**
     * @var CompanyRepositoryInterface
     */
    protected $companyRepository;

    public function init()
    {
        $this->companyRepository = $this->get('mango_core_domain.company_repository');
    }

    /**
     * Retrieve all companies.
     *
     * @Rest\QueryParam(name="sort", description="Sort results by fields in the following notation [field]:[order], where order can be 'a' (ascending) or 'd' (descending)", default=null)
     * @Rest\QueryParam(name="page", description="Pagination for your results", default=1)
     * @Rest\QueryParam(name="limit", description="Number of results to fetch", default=10)
     * @Rest\QueryParam(name="fields", description="Filter fields to serialize")
     * @ApiDoc(
     *  section="Companies"
     * )
     *
     * @param ParamFetcherInterface $paramFetcher
     * @return array
     */
    public function getCompaniesAction(ParamFetcherInterface $paramFetcher)
    {
        $query = $this->queryExtractor->extract($paramFetcher);
        return array('companies' => $this->companyRepository->findByQuery($query));
    }

    /**
     * Get a single company
     *
     * @ApiDoc(
     *  section="Companies"
     * )
     */
    public function getCompanyAction($id)
    {
        return array('company' => $this->companyRepository->find($id));
    }

    /**
     * Get the pages for a specific company
     *
     * @Rest\QueryParam(name="orderBy", description="Sort results by fields in the following notation [field]:[order], where order can be 'a' (ascending) or 'd' (descending)", default=null)
     * @Rest\QueryParam(name="page", description="Pagination for your results", default=1)
     * @Rest\QueryParam(name="limit", description="Number of results to fetch", default=10)
     * @Rest\QueryParam(name="fields", description="Filter fields to serialize")
     */
    public function getCompanyPagesAction($id, ParamFetcherInterface $paramFetcher)
    {
        /** @var ActionHandlerInterface $handler */
        $handler = $this->get('mango_api_rest.phpcr_action_handler');
        return $handler->find('Mango\\API\\RestBundle\\Document\\Page', $paramFetcher);
    }
}