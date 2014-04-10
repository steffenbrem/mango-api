<?php
/**
 * Created by PhpStorm.
 * User: Steffen
 * Date: 10/04/14
 * Time: 11:18
 */

namespace Mango\API\RestBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface;
use Mango\CoreDomain\Repository\WorkspaceRepositoryInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


/**
 * Class WorkspacesController
 * @package Mango\API\RestBundle\Controller
 */
class WorkspacesController extends RestController
{
    /**
     * @var WorkspaceRepositoryInterface
     */
    protected $workspacesRepository;

    public function init()
    {
        $this->workspacesRepository = $this->get('mango_core_domain.workspace_repository');
    }

    /**
     * Retrieve all users of Mango.
     *
     * @Rest\QueryParam(name="sort", description="Sort results by fields in the following notation [field]:[order], where order can be 'a' (ascending) or 'd' (descending)", default=null)
     * @Rest\QueryParam(name="page", description="Pagination for your results", default=1)
     * @Rest\QueryParam(name="limit", description="Number of results to fetch", default=10)
     * @Rest\QueryParam(name="fields", description="Filter fields to serialize")
     * @ApiDoc(
     *  section="Workspaces"
     * )
     * @param \FOS\RestBundle\Request\ParamFetcherInterface $paramFetcher
     * @return mixed
     */
    public function getWorkspacesAction(ParamFetcherInterface $paramFetcher)
    {
        $query = $this->queryExtractor->extract($paramFetcher);
        return array('workspaces' => $this->workspacesRepository->findByQuery($query));
    }

    /**
     * Find a single workspace by id.
     *
     * @param $id
     * @return mixed
     */
    public function getWorkspaceAction($id)
    {
        return array('workspace' => $this->workspacesRepository->find($id));
    }
} 