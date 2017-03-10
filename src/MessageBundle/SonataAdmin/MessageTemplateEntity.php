<?php
namespace MessageBundle\SonataAdmin;

use Application\Sonata\AdminEntity\AbstractAdminEntity;
use MessageBundle\Services\MessageService;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MessageTemplateEntity extends AbstractAdminEntity
{
    /**
     * MessageTemplateEntity constructor.
     *
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param MessageService $service
     */
    public function __construct($code, $class, $baseControllerName, $service = null)
    {
        $this->service = $service;
        $this->listFields = [
            'id',
            'subject',
            'template',
        ];
        parent::__construct($code, $class, $baseControllerName);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper
            ->add('_action', null, [
                'header_style' => 'width: 15%',
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ]);
    }

    /**
     * @return string
     */
    private function getHelper()
    {
        $metadata = $this->service->getAllowVariables();
        $helper = $this->trans('form.template.helper_message') . '<br>';
        foreach ($metadata as $field) {
            $helper .= ' {{ ' . $field    . ' }}' . ' / {{' . $field . '}} <br>';
        }
        return $helper;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $helper = $this->getHelper();
        $formMapper
            ->with('form.template.group_template', ['class' => 'col-md-7'])
                ->add('subject', 'text')
                ->add('template', 'sonata_simple_formatter_type', [
                    'format' => 'richhtml',
                    'ckeditor_context' => 'default', // optional
                ])
            ->end()
            ->with('form.template.label_helper', [
                'class' => 'col-md-5',
                'description' => $helper,
            ])
            ->end();
    }
}
