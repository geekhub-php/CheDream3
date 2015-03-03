<?php

namespace AppBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class FaqController extends AbstractController
{
    /**
     * Get Faqs,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all Faq",
     * output="array<AppBundle\Document\Faq>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      204 = "Returned when the Faqs is not found"
     * }
     * )
     *
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count faqs at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     *
     *
     * @param  ParamFetcher $paramFetcher
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getFaqsAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->get('doctrine_mongodb.odm.document_manager');
        $faqsQuery = $manager->getRepository('AppBundle:Faq')
                            ->findAll();

        $view = View::create();

        if (count($faqsQuery) == 0) {
            $view->setStatusCode(204);
        } else {
            $view->setData([
                "faqs" => $faqsQuery,
            ]);
        }

        return $view;
    }

    /**
     * @ApiDoc(
     * resource = true,
     * description = "Gets faq by slug",
     * output="array<AppBundle\Document\Faq>",
     * statusCodes = {
     *      200 = "Returned if faq exist",
     *      404 = "Returned if faq not exist"
     * }
     * )
     *
     * @param $slug
     * @return View
     */
    public function getFaqAction($slug)
    {
        $manager = $this->get('doctrine_mongodb.odm.document_manager');
        $faq = $manager->getRepository('AppBundle:Faq')
                       ->findOneBySlug($slug);

        $view = View::create();

        if (!$faq) {
            $view->setStatusCode(404);
        } else {
            $view->setData([
                "faq" => $faq,
            ]);
        }

        return $view;
    }
}
