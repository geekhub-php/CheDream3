<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;

class ContributeController extends AbstractController
{
    /**
     * @ApiDoc(
     *      resource = true,
     *      description = "create single contribute",
     *      input = "AppBundle\Document\Contribute",
     *      statusCodes = {
     *          201 = "Returned when successful create",
     *          404 = "Returned when dream is not found"
     *      }
     * )
     *
     * @QueryParam(name="idResource", strict=true, requirements="[a-zA-Z0-9]+", description="id resource", nullable=true)
     *
     * @param ParamFetcher $param
     * @param Request      $request
     * @param $slugDream
     *
     * @return View
     *
     * @View(statusCode=201)
     */
    public function postContributeAction(ParamFetcher $param, Request $request, $slugDream)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $contribute = $this->get('serializer')->deserialize($request->getBody(), 'AppBundle\Document\Contribute', 'json');

        $idResource = $param->get('idResource');
        $resource = null;

        $dream = $dm->getRepository('AppBundle:Dream')
                    ->findOneBySlug($slugDream);

        if (!$dream) {
            throw new NotFoundHttpException('Dream with this slug not isset');
        }

        if (!is_null($idResource)) {
            $resource = $dm->getRepository('AppBundle:Resource')
                        ->findOneById($idResource);

            if (!$resource) {
                throw new NotFoundHttpException('Resource with this id not isset');
            }
        }

        $contribute = $this->get('app.services.contribute_factory')
                            ->setDream($dream)
                            ->setResource($resource)
                            ->setUser($this->getUser())
                            ->contribute($contribute)
        ;

        $dm->persist($contribute);
        $dm->flush();
    }
}
