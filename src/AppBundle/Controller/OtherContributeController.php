<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\View\View;

class OtherContributeController extends AbstractController
{
    /**
     * @ApiDoc(
     *      resource = true,
     *      description = "create single financial contribute",
     *      parameters = {
     *          {"name" = "financial_resource", "dataType" = "string", "required" = true, "description" = "slug resource that contributet" },
     *          {"name" = "quantity", "dataType" = "integer", "required" = true, "description" = "count contributet resources" },
     *          {"name" = "hidden_contributor", "dataType" = "boolean", "required" = true, "description" = "that boolean value make user hidden" }
     *      },
     *      statusCodes = {
     *          204 = "Returned when successful create",
     *          404 = "Returned when dream is not found"
     *      }
     * )
     *
     * @param Request $request
     * @param $slug
     *
     * @return View
     */
    public function postOtherContributesAction(Request $request, $slug)
    {
        $data = $request->request->all();
        $user = $this->getUser();

        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $dream = $dm->getRepository('AppBundle:Dream')
                    ->findOneBySlug($slug);

        $view = View::create();

        if (!$dream) {
            $view->setStatusCode(404);
        } else {
            $serializer = $this->get('serializer');

            $data = $serializer->serialize($data, 'json');
            $other_contribute = $serializer->deserialize($data, 'AppBundle\Document\OtherContribute', 'json');

            $other_contribute->setDream($dream);
            $other_contribute->setUser($user);

            $view->setStatusCode(204);

            $dm->persist($other_contribute);
            $dm->flush();
        }

        return $view;
    }
}
