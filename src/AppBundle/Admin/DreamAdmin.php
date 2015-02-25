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
            ->add('author', 'entity', array('class' => 'AppBundle\Document\User'))
            ->add('body') //if no type is specified, SonataAdminBundle tries to guess it
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