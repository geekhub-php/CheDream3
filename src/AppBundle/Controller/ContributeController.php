<?php

namespace AppBundle\Controller;

use AppBundle\Document\OtherContribute;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations\View;

class ContributeController extends AbstractController
{
    /**
     * @ApiDoc(
     *      resource = true,
     *      description = "create single contribute",
     *      parameters = {
     *          {"name" = "idResource", "dataType" = "integer", "required" = false, "description" = "id resource" },
     *          {"name" = "quantity", "dataType" = "integer", "required" = true, "description" = "count contributet resources" },
     *          {"name" = "hidden_contributor", "dataType" = "boolean", "required" = true, "description" = "that boolean value make user hidden" }
     *      },
     *      statusCodes = {
     *          201 = "Returned when successful create",
     *          404 = "Returned when dream is not found"
     *      }
     * )
     *
     * @param ParamFetcher $param
     * @param Request $request
     * @param $slugDream
     *
     * @return View
     *
     * @View(statusCode=201)
     */
    public function postContributeAction(ParamFetcher $param, Request $request, $slugDream)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $data = $request->request->all();
        $user = $this->getUser();

        $idResource = $param->get('idResource');

        $contribute = $this->get('app.services.contribute_dream')->contribute($dm, $user, $data, $slugDream, $idResource);

        $dm->persist($contribute);
        $dm->flush();
    }
}
