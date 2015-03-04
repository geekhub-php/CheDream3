<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends Admin
{
    protected $baseRouteName = 'AppBundle\Document\User';
    protected $baseRoutePattern = 'User';
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'firstName',
    ];

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username')
            ->add('email')
            ->add('facebookId')
            ->add('vkontakteId')
            ->add('odnoklassnikiId')
            ->add('locked', null, array('required' => false))
            ->add('enabled', null, array('required' => false));
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     *
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email');
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('avatar', 'string')
            ->add('firstName', 'string')
            ->add('email')
            ->add('phone')
            ->add('facebookId', 'boolean', ['label' => 'Fb'])
            ->add('vkontakteId', 'boolean', ['label' => 'Vk'])
            ->add('odnoklassnikiId', 'boolean', ['label' => 'Ok'])
//            ->add('lastLogin')
//            ->add('locked', null, array('required' => false, 'editable' => true))
//            ->add('enabled', null, array('required' => false, 'editable' => true))
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Route\RouteCollection $collection
     *
     * @return void
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'edit'));
    }
}
