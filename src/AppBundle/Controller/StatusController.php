<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;

class StatusController extends FOSRestController
{
//    /**
//     * Get Status,
//     *
//     * @ApiDoc(
//     * resource = true,
//     * description = "Gets all statuses",
//     * output="array<AppBundle\Document\Status>",
//     * statusCodes = {
//     *      200 = "Returned when successful",
//     *      404 = "Returned when the status is not found"
//     * }
//     * )
//     *
//     * RestView()
//     * @param
//     * @return View
//     *
//     * @throws NotFoundHttpException when page not exist
//     */
//    public function getStatusAction()
//    {
//        $manager = $this->get('doctrine_mongodb')->getManager();
//        $status = $manager->getRepository('AppBundle:Status')->findAll();
//        $restView = View::create();
//
//        if (count($status) == 0) {
//            $restView->setStatusCode(204);
//        }
//
//        $restView->setData($status);
//
//        return $restView;
//    }

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
     * @QueryParam(name="status", requirements="[a-z]+", description="Status")
     *
     * @param  ParamFetcher $paramFetcher
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getDreamsAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();

        $restView = View::create();

        switch ($paramFetcher->get('status')) {
            case 'submitted':
                $dreams = $manager->createQueryBuilder('AppBundle:Dream')
                    ->field('status')->equals('submitted')
                    ->getQuery()->execute();
                $restView->setData($dreams);
                break;
            case 'rejected':
                $dreams = $manager->createQueryBuilder('AppBundle:Dream')
                    ->field('status')->equals('rejected')
                    ->getQuery()->execute();
                $restView->setData($dreams);
                break;
            case 'collecting-resources':
                $dreams = $manager->createQueryBuilder('AppBundle:Dream')
                    ->field('status')->equals('collecting-resources')
                    ->getQuery()->execute();
                $restView->setData($dreams);
                break;
            case 'implementing':
                $dreams = $manager->createQueryBuilder('AppBundle:Dream')
                    ->field('status')->equals('implementing')
                    ->getQuery()->execute();
                $restView->setData($dreams);
                break;
            case 'completed':
                $dreams = $manager->createQueryBuilder('AppBundle:Dream')
                    ->field('status')->equals('completed')
                    ->getQuery()->execute();
                $restView->setData($dreams);
                break;
            case 'success':
                $dreams = $manager->createQueryBuilder('AppBundle:Dream')
                    ->field('status')->equals('success')
                    ->getQuery()->execute();
                $restView->setData($dreams);
                break;
            case 'fail':
                $dreams = $manager->createQueryBuilder('AppBundle:Dream')
                    ->field('status')->equals('fail')
                    ->getQuery()->execute();
                $restView->setData($dreams);
                break;
        }

        if (!in_array($paramFetcher->get('status'), ['submitted', 'rejected'])) {
            $restView->setStatusCode(400);
        }

        return $restView;
    }
}
