<?php
namespace MessageBundle\SonataAdmin;

use Application\Sonata\UserBundle\Entity\User;
use MessageBundle\Entity\MessageTemplate;
use MessageBundle\Entity\MessageUser;
use MessageBundle\Services\MessageService;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

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
            ->add('message', 'sonata_type_model_list', [
                'empty_data' => false,
            ])
            ->add('user', 'sonata_type_model', [
                'multiple'   => true,
                'mapped'     => false,
                'empty_data' => false,
            ]);
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        // remove action edit from this entity
        $collection->remove('edit');
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $this->service->sendMessage($object->getMessage(), $object->getUser());
    }

    /**
     * @param mixed $object
     *
     * @return mixed
     */
    public function create($object)
    {
        // delete old object from queue on deleting
        $this->entityManager->clear();

        $uniqId     = $this->getRequest()->query->get('uniqid');
        $formData   = $this->getRequest()->request->get($uniqId);

        $messageId  = $formData['message'];
        $users      = $formData['user'];

        foreach ($users as $userId) {
            $message = $this->entityManager->getRepository(MessageTemplate::class)->find($messageId);
            $user    = $this->entityManager->getRepository(User::class)->find($userId);

            // create new object
            $object = new MessageUser();
            $object->setMessage($message);
            $object->setUser($user);
            // push it
            parent::create($object);
        }
        return $object;
    }
}
