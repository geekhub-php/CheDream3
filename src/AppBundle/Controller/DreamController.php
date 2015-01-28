<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 28.01.15
 * Time: 15:10
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DreamController extends FOSRestController
{
    /**
     * Get single Dream,
     *
     * @ApiDoc(
     * resource = true,
     * description = "Gets a Dream for a given id",
     * output = "AppBundle\Document\Dream",
     * statusCodes = {
         * 200 = "Returned when successful",
         * 404 = "Returned when the page is not found"
     * }
     * )
     *
     * @Annotations\View(templateVar="deream")
     *
     * @param Request $request the request object
     * @param int     $id      the page id
     *
     * @return array
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getDreamAction($id)
    {
        return $this->container->get('doctrine_mongodb.odm.document_manager')->getRepository('AppBundle:Dream')->find($id);
    }
}
