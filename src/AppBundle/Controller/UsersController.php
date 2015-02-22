<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\View\View;
use Symfony\Component\Config\Definition\Exception\Exception;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class UsersController extends FOSRestController
{
    /**
     * Get Users,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets all Users",
     * output="array<AppBundle\Document\User>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the user is not found"
     * }
     * )
     *
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Count users at one page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     *
     * @RestView
     *
     * @param  ParamFetcher $paramFetcher
     * @return View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function getUsersAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->get('doctrine_mongodb')->getManager();
        $users = $manager->createQueryBuilder('AppBundle:User')->getQuery();

        if (count($users) == 0) {
            throw new Exception("204 No Content");
        }

        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $paginator  = $this->get('knp_paginator');
        $users = $paginator->paginate(
            $users,
            $paramFetcher->get('page', $page),
            $limit
        );

        return $users;
    }

    /**
     * Get User for id,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets User for id",
     * output="array<AppBundle\Document\User>",
     * statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the user is not found"
     * }
     * )
     *
     * RestView()
     * @param
     * @return View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getUserAction($id)
    {
        $user = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:User')->findOneById($id);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        return $user;
    }
}
