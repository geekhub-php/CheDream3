<?php

namespace AppBundle\Controller;

use AppBundle\Model\DreamsResponse;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

class DreamController extends FOSRestController
{
    /**
     * Gets Dreams by status,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets Dreams by status",
     * output =   { "class" = "AppBundle\Document\Dream", "collection" = true, "collectionName" = "status" },
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the status is not found"
     * }
     * )
     *
     * RestView()
     *
     * @QueryParam(name="status", strict=true, requirements="[a-z]+", description="Status", nullable=true)
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count statuses at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     * @QueryParam(name="sort_by", strict=true, requirements="[a-z]+", default="status_update", description="Sort by", nullable=true)
     * @QueryParam(name="sort_order", strict=true, requirements="[a-z]+", default="DESC", description="Sort order", nullable=true)
     * @param  ParamFetcher $paramFetcher
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */

    public function getDreamsAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();

        if(!$paramFetcher->get('status')) {
            $dreamsQuery = $manager->createQueryBuilder('AppBundle:Dream')
                ->sort($paramFetcher->get('sort_by'), $paramFetcher->get('sort_order'))
                ->field('currentStatus')->notEqual('fail')
                ->getQuery()->execute()->toArray();
        }else{
            $dreamsQuery = $manager->createQueryBuilder('AppBundle:Dream')
                ->sort($paramFetcher->get('sort_by'), $paramFetcher->get('sort_order'))
                ->field('currentStatus')->equals($paramFetcher->get('status'))
                ->getQuery()->execute()->toArray();
        }

        $dreamsManager = new DreamsResponse();
        $dreamsManager->setSortOrder($paramFetcher->get('sort_order'));

        $paginator = new Pagerfanta(new ArrayAdapter($dreamsQuery));
        $paginator
            ->setMaxPerPage($paramFetcher->get('limit'))
            ->setCurrentPage($paramFetcher->get('page'))
        ;

        $dreamsManager->setDreams($paginator->getCurrentPageResults());
        $dreamsManager->setPageCount($paginator->getNbPages());

        $nextPage = $paginator->hasNextPage() ?
            $this->generateUrl('get_dreams', array(
                    'limit' => $paramFetcher->get('limit'),
                    'page' => $paramFetcher->get('page')+1,
                )
            ) :
            'false';

        $previsiousPage = $paginator->hasPreviousPage() ?
            $this->generateUrl('get_dreams', array(
                    'limit' => $paramFetcher->get('limit'),
                    'page' => $paramFetcher->get('page')-1,
                )
            ) :
            'false';

        $dreamsManager->setNextPage($nextPage);
        $dreamsManager->setPreviousPage($previsiousPage);

        return $dreamsManager;
    }

    /**
     * Get single Dream for slug,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets Dream for slug",
     * output="array<AppBundle\Document\Dream>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the Dream is not found"
     * }
     * )
     *
     *
     * RestView()
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getDreamAction($slug)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $dream = $manager->getRepository('AppBundle:Dream')->findBySlug($slug);
        $restView = View::create();

        if (count($dream) == 0) {
            $restView->setStatusCode(204);
        }

        $restView->setData($dream);

        return $restView;
    }
}
