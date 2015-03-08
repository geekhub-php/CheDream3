<?php

namespace AppBundle\Controller;

use AppBundle\Document\Dream;
use AppBundle\Document\EquipmentResource;
use AppBundle\Document\FinancialResource;
use AppBundle\Document\WorkResource;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Model\DreamsResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

class DreamController extends AbstractController
{
    /**
     * Gets Dreams by status,.
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
     * @QueryParam(name="sort_by", strict=true, requirements="^[a-zA-Z]+", default="createdAt", description="Sort by", nullable=true)
     * @QueryParam(name="sort_order", strict=true, requirements="^[a-zA-Z]+", default="DESC", description="Sort order", nullable=true)
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getDreamsAction(ParamFetcher $paramFetcher)
    {
        $repository = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Dream');

        if (!$paramFetcher->get('status')) {
            $queryBuilder = $repository->createQueryBuilder('dream')
                ->sort($paramFetcher->get('sort_by'), $paramFetcher->get('sort_order'))
                ->field('dream.currentStatus')->notEqual('fail')
                ->getQuery()->execute()->toArray();
        } else {
            $queryBuilder = $repository->createQueryBuilder('dream')
                ->sort($paramFetcher->get('sort_by'), $paramFetcher->get('sort_order'))
                ->field('currentStatus')->equals($paramFetcher->get('status'))
                ->getQuery()->execute()->toArray();
        }

        $dreamsResponse = new DreamsResponse();
        $dreamsResponse->setSortOrder($paramFetcher->get('sort_order'));

        $paginator = new Pagerfanta(new ArrayAdapter($queryBuilder));
        $paginator
            ->setMaxPerPage($paramFetcher->get('limit'))
            ->setCurrentPage($paramFetcher->get('page'))
        ;

        $dreamsResponse->setDreams($paginator->getCurrentPageResults());
        $dreamsResponse->setPageCount($paginator->getNbPages());

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

        $dreamsResponse->setNextPage($nextPage);
        $dreamsResponse->setPreviousPage($previsiousPage);

        return $dreamsResponse;
    }

    /**
     * Get single Dream for slug,.
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
     * @RestView()
     * @param
     *
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getDreamAction($slug)
    {
        $dream = $this->get('doctrine_mongodb.odm.document_manager')
                      ->getRepository('AppBundle:Dream')
                     ->findOneBySlug($slug);

        if (!$dream) {
            throw new NotFoundHttpException();
        }

        return $dream;
    }

    /**
     * Create dream
     *
     * @ApiDoc(
     *      resource = true,
     *      description = "Create single dream",
     *      parameters={
     *          {"name"="[title]", "dataType"="string", "required"=true, "description"="Dream name"},
     *          {"name"="[description]", "dataType"="string", "required"=true, "description"="Description about dream"},
     *          {"name"="[phone]", "dataType"="integer", "required"=true, "description"="Phone number", "format"="(xxx) xxx xxx xxx"},
     *          {"name"="[equipment_resource][][title]", "dataType"="string", "required"=true, "description"="title equipment resource"},
     *          {"name"="[equipment_resource][][quantity]", "dataType"="int", "required"=true, "description"="quantity equipment resource"},
     *          {"name"="[financial_resource][][title]", "dataType"="string", "required"=true, "description"="title financial resource"},
     *          {"name"="[financial_resource][][quantity]", "dataType"="int", "required"=true, "description"="quantity financial resource"},
     *          {"name"="[work_resource][][title]", "dataType"="string", "required"=true, "description"="title work resource"},
     *          {"name"="[work_resource][][quantity]", "dataType"="int", "required"=true, "description"="quantity work resource"},
     *      },
     *      output = "string",
     *      statusCodes = {
     *          201 = "Dream sucessful created",
     *          400 = "When dream not created"
     *      }
     * )
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postDreamAction(Request $request)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $data = $request->request->all();

        $user = $this->getUser();

        $data = $this->get('serializer')->serialize($data, 'json');
        $dream = $this->get('serializer')->deserialize($data, 'AppBundle\Document\Dream', 'json');
        $dream->setAuthor($user);

        $dm->persist($dream);
        $dm->flush();

        $restView = View::create();
        $restView->setStatusCode(201);

        $restView->setData([
            "link" => $this->get('router')->generate('get_dream', ['slug' => $dream->getSlug()], true),
        ]);

        return $restView;
    }

    /**
     * Update existing dream from the submitted data or create a new dream at a specific location.
     *
     * @ApiDoc(
     * resource = true,
     * description = "Create/Update single dream",
     * parameters={
     *          {"name"="[title]", "dataType"="string", "required"=true, "description"="Dream name"},
     *          {"name"="[description]", "dataType"="string", "required"=true, "description"="Description about dream"},
     *          {"name"="[phone]", "dataType"="integer", "required"=true, "description"="Phone number", "format"="(xxx) xxx xxx xxx"},
     *          {"name"="[equipment_resource][][title]", "dataType"="string", "required"=true, "description"="title equipment resource"},
     *          {"name"="[equipment_resource][][quantity]", "dataType"="int", "required"=true, "description"="quantity equipment resource"},
     *          {"name"="[financial_resource][][title]", "dataType"="string", "required"=true, "description"="title financial resource"},
     *          {"name"="[financial_resource][][quantity]", "dataType"="int", "required"=true, "description"="quantity financial resource"},
     *          {"name"="[work_resource][][title]", "dataType"="string", "required"=true, "description"="title work resource"},
     *          {"name"="[work_resource][][quantity]", "dataType"="int", "required"=true, "description"="quantity work resource"},
 *     },
     * statusCodes = {
     * 200 = "Dream successful update",
     * 404 = "Return when dream with current slug not isset"
     * }
     * )
     *
     *
     * @param  Request $request the request object
     * @param  string  $slug    the page id
     * @return mixed
     */
    public function putDreamAction(Request $request, $slug)
    {
        $data = $request->request->all();
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $dreamOld = $dm->getRepository('AppBundle:Dream')
                        ->findOneBySlug($slug);

        $data = $this->get('serializer')->serialize($data, 'json');
        $dreamNew = $this->get('serializer')->deserialize($data, 'AppBundle\Document\Dream', 'json');

        $view = View::create();

        if (!$dreamOld) {
            $dreamNew->setAuthor($this->getUser());

            $dm->persist($dreamNew);
            $dm->flush();

            $view->setStatusCode(404);
        } else {
            $this->get('app.services.object_updater')->updateObject($dreamOld, $dreamNew);

            $dm->flush();

            $view->setStatusCode(200);
        }

        return $view;
    }
}
