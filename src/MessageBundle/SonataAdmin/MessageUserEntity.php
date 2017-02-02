<?php
namespace MessageBundle\SonataAdmin;

use MessageBundle\Entity\MessageUser;
use MessageBundle\Services\MessageService;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\DateTime;

class MessageUserEntity extends AbstractAdmin
{
    /**
     * @var MessageService
     */
    private $service;

    /**
     * @var
     */
    private $entityManager;

    /**
     * MessageUserEntity constructor.
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param null $service
     * @param null $entityManager
     */
    public function __construct($code, $class, $baseControllerName, $service = null, $entityManager = null)
    {
        $this->service = $service;
        $this->entityManager = $entityManager;
        parent::__construct($code, $class, $baseControllerName);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('message')
            ->add('user')
            ->add('created');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('message', 'sonata_type_model_list')
            ->add('user', 'sonata_type_model', [
//                'multiple' => true,
            ]);
    }

    public function prePersist($object)
    {
        $this->service->sendMessage($object->getMessage(), $object->getUser());
    }
}
