<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\View\View;

class FinancialContributeController extends AbstractController
{
    /**
     * @ApiDoc(
     *      resource = true,
     *      description = "create single financial contribute",
     *      parameters = {
     *          {"name" = "financial_resource", "dataType" = "array<AppBundle\Document\FinancialResource>", "required" = true, "description" = "resource that contributet" },
     *          {"name" = "quantity", "dataType" = "integer", "required" = true, "description" = "count contributet resources" }
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
    public function postFinancialContributesAction(SymfonyRequest $request, $slug)
    {
        $data = $request->request->all();
        $user = $this->getUser();

        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $slugResource = $request->request->get('equipment_contribute');

        $dream = $this->get('doctrine_mongodb.odm.document_manager')
            ->getRepository('AppBundle:Dream')
            ->findOneBySlug($slug);

        $financial_resource = $this->get('doctrine_mongodb.odm.document_manager')
            ->getRepository('AppBundle:FinancialResource')
            ->findOneBySlug($slugResource);

        $view = View::create();

        if (!$dream) {
            $view->setStatusCode(404);
        } else {
            $data = $this->get('serializer')->serialize($data, 'json');
            $financial_contribute = $this->get('serializer')
                                        ->deserialize($data, 'AppBundle\Document\FinancialContribute', 'json');

            $financial_contribute->setEquipmentResource($financial_resource);
            $financial_contribute->setDream($dream);
            $financial_contribute->setUser($user);

            $view->setStatusCode(204);

            $dm->persist($financial_contribute);
            $dm->flush();
        }

        return $view;
    }
}
