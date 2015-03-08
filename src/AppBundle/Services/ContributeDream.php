<?php

namespace AppBundle\Tests\Services;

use AppBundle\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use AppBundle\Document\OtherContribute;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContributeDream
{
    public function contribute(DocumentManager $dm, User $user, $data, $slugDream, $idResource)
    {
        $dream = $dm->getRepository('AppBundle:Dream')
                    ->findOneBySlug($slugDream);

        if (!$dream) {
            throw new NotFoundHttpException('Dream with this slug not isset');
        }

        $contribute = null;

        if (!is_null($idResource)) {
            $resource = $dm->getRepository('AppBundle:Resource')
                           ->findOneById($idResource);

            if (!$resource) {
                throw new NotFoundHttpException('Resource with this id not isset');
            }

            $type = "\\AppBundle\\Document\\".str_replace('Resource', 'Contribute', $resource->getType());

            $contribute = new $type();
            $contribute->setResource($resource);
        } else {
            $contribute = new OtherContribute();
            $contribute->setTitle($data['title']);
        }

        $contribute->setDream($dream)
                    ->setUser($user)
                    ->setQuantity($data['quantity'])
                    ->setHiddenContributor($data['hiddenContributor'])
        ;

        return $contribute;
    }
}