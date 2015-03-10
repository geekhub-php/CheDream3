<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class FaqAdmin extends Admin
{
    protected $baseRouteName = 'AppBundle\Document\Faq';
    protected $baseRoutePattern = 'Faq';
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by'    => 'title',
    ];

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', ['label' => 'Faq Title'])
            ->add('question', 'text')
            ->add('answer', 'text')
            ->add('createdAt', 'date')
            ->add('updatedAt', 'date')
            ->add('deletedAt', 'date')

        ;
    }

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title', 'text', ['label' => 'Заголовок'])
            ->add('question', 'text', ['label' => 'Питання'])
            ->add('answer', 'text', ['label' => 'Відповідь'])
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     *
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('question')
            ->add('answer')
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
            ->addIdentifier('title', 'text', ['label' => 'Заголовок'])
            ->add('question', 'text', ['label' => 'Питання'])
            ->add('answer', 'text', ['label' => 'Відповідь'])
            ->add('_action', 'actions', [
                'label' => 'Дії',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }
}
