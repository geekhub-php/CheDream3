<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use AppBundle\Document\Status;

class DreamAdmin extends Admin
{
    protected $baseRouteName = 'AppBundle\Document\Dream';
    protected $baseRoutePattern = 'Dream';
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by'    => 'updatedAt',
    ];

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $choiceOptions = Status::getStatusesArray();
        $datagridMapper
            ->add('currentStatus',null, [], 'choice', [
                'choices' => $choiceOptions
            ])
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('mediaPoster', 'string')
            ->add('title')
            ->add('author.phone')
            ->add('author', 'string')
            ->add('currentStatus', null)
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Route\RouteCollection $collection
     *
     * @return void
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'edit', 'delete']);
    }
}
