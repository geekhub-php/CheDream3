<?php

namespace AppBundle\Controller;

use AppBundle\Document\OtherContribute;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @param Request $request
     * @param $slug
     * @param $type
     *
     * @return View
     */
    public function postContributeAction(ParamFetcher $param, Request $request, $slugDream)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $dream = $dm->getRepository('AppBundle:Dream')
                    ->findOneBySlug($slugDream);

        if (!$dream) {
            throw new NotFoundHttpException('Dream with this slug not isset');
        }

        $data = $request->request->all();
        $user = $this->getUser();

        $view = View::create();

        $idResource = $param->get('idResource');
        $contribute = null;

        if (!is_null($idResource)) {
            $resource = $dm->getRepository('AppBundle:Resource')
                            ->findOneById($idResource);

            $type = $resource->getType();

            $contribute = new $type();
            $contribute->setResource($resource);
        } else {
            $contribute = new OtherContribute();
            $contribute->setTitle($data['title']);
        }

        $contribute->setDream($dream);
        $contribute->setUser($user);
        $contribute->setQuantity($data['quantity']);
        $contribute->setHiddenContributor($data['hiddenContributor']);

        $dm->persist($contribute);
        $dm->flush();

        $view->setStatusCode(201);

        return $view;
    }
}
