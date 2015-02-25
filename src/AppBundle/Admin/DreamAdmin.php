<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Document\Dream;

class DreamAdmin extends Admin
{
    protected $baseRouteName = 'AppBundle\Document\Dream';
    protected $baseRoutePattern = 'Dream';
    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by'    => 'name',
    ];
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', array('label' => 'Dream Title'))
            ->add('description', 'text')
            ->add('rejectedDescription', 'text')
            ->add('implementedDescription', 'text')
            ->add('completedDescription', 'text')
            ->add('phone', 'text')
            ->add('createdAt', 'date')
            ->add('updatedAt', 'date')
            ->add('deletedAt', 'date')
            ->add('expiredDate', 'date')
            ->add('financialCompleted')
            ->add('workCompleted')
            ->add('equipmentCompleted')
//            ->add('usersWhoFavorites', 'document', array('class' => 'AppBundle\Document\User'))
            ->add('favoritesCount')
            ->add('author', 'document', array('class' => 'AppBundle\Document\User'))
            ->add('statuses', 'document', array('class' => 'AppBundle\Document\Status'))
            ->add('currentStatus', 'text')
            ->add('dreamFinancialResources', 'document', array('class' => 'AppBundle\Document\FinancialResource'))
            ->add('dreamEquipmentResources', 'document', array('class' => 'AppBundle\Document\EquipmentResource'))
            ->add('dreamWorkResources', 'document', array('class' => 'AppBundle\Document\WorkResource'))
//            ->add('dreamFinancialContributions', 'document', array('class' => 'AppBundle\Document\FinancialContribute'))
//            ->add('dreamEquipmentContributions', 'document', array('class' => 'AppBundle\Document\EquipmentContribute'))
//            ->add('dreamWorkContributions', 'document', array('class' => 'AppBundle\Document\WorkContribute'))
//            ->add('dreamOtherContributions', 'document', array('class' => 'AppBundle\Document\OtherContribute'))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('author')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('slug')
            ->add('author')
        ;
    }
}
