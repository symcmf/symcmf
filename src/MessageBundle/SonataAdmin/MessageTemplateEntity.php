<?php
namespace MessageBundle\SonataAdmin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MessageTemplateEntity extends AbstractAdmin
{
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('subject')
            ->add('template')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Template form', ['class' => 'col-md-7'])
            ->add('subject', 'text')
            ->add('template', 'ckeditor')
            ->end()
            ->with('Helper', ['class' => 'col-md-5'])
            ->end();
    }


}