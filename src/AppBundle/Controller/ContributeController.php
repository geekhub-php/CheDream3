<?php

namespace AppBundle\Controller;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ContributeController extends AbstractController
{
    /**
     * @ApiDoc(
     *      resource = true,
     *      description = "create single contribute",
     *      parameters = {
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
     * @param $type
     *
     * @return View
     */
    public function postContributeAction(Request $request, $slug, $type)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $data = $request->request->all();
        $user = $this->getUser();
        $view = View::create();

        if ($type != "other") {
            $repository = "AppBundle\\Document\\".ucfirst($type)."Resource";
            $document = "AppBundle\\Document\\".ucfirst($type)."Contribute";

            $resource = $this->get('doctrine_mongodb.odm.document_manager')
                ->getRepository($repository)
                ->findOneBySlug($slug);

            $data = $this->get('serializer')->serialize($data, 'json');
            $contribute = $this->get('serializer')->deserialize($data, $document, 'json');

            $setter = 'set'.ucfirst($type).'Resource';

            $contribute->$setter($resource);
            $contribute->setDream($resource->getDream());
            $contribute->setUser($user);

            $view->setStatusCode(204);

            $dm->persist($contribute);
        } else {
            $dream = $dm->getRepository('AppBundle:Dream')
                ->findOneBySlug($slug);

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
            }
        }

        $dm->flush();

        return $view;
    }
}
