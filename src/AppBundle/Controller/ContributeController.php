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
     *      parameters = {
     *          {"name" = "[quantity]", "dataType" = "integer", "required" = true, "description" = "count contributet resources" },
     *          {"name" = "[hidden_contributor]", "dataType" = "boolean", "required" = true, "description" = "that boolean value make user hidden" }
     *      },
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
                            ->contribute((object) $request->request->all())
        ;

        $dm->persist($contribute);
        $dm->flush();
    }
}
