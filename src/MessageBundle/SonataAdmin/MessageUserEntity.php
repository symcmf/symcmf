<?php
namespace MessageBundle\SonataAdmin;

use Application\Sonata\AdminEntity\AbstractAdminEntity;
use Application\Sonata\UserBundle\Entity\Group;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use MessageBundle\Entity\MessageTemplate;
use MessageBundle\Entity\MessageUser;
use MessageBundle\Services\MessageService;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class MessageUserEntity extends AbstractAdminEntity
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * MessageUserEntity constructor.
     *
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param MessageService $service
     * @param null $entityManager
     */
    public function __construct($code, $class, $baseControllerName, $service = null, $entityManager = null)
    {
        $this->service = $service;
        $this->entityManager = $entityManager;
        $this->listFields = [
            'message',
            'user',
            'created',
        ];
        parent::__construct($code, $class, $baseControllerName);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Send message', ['class' => 'col-md-12'])
                ->add('message', 'sonata_type_model_list', [
                    'empty_data' => false,
                ])
            ->end()
            ->with('To users', ['class' => 'col-md-6'])
                ->add('user', 'sonata_type_model', [
                    'multiple'   => true,
                    'mapped'     => false,
                ])
            ->end()
            ->with('To users from groups', ['class' => 'col-md-6'])
                ->add('groups', 'sonata_type_model', [
                    'multiple'   => true,
                    'class'      => 'Application\Sonata\UserBundle\Entity\Group',
                    'mapped'     => false,
                ])
            ->end();
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
     * @param $userIds
     * @param $groupIds
     *
     * @return array
     */
    private function getUsers($userIds, $groupIds)
    {
        $usersAll = [];

        // get selected users by their ids
        foreach ($userIds as $userId) {
            if (($user = $this->entityManager->getRepository(User::class)->find($userId)) !== null) {
                $usersAll[] = $user;
            }
        }
        // get all users from selected groups
        foreach ($groupIds as $id) {
            $users = $this->entityManager->getRepository(User::class)->findByGroupId($id);
            $usersAll = array_merge_recursive($usersAll, $users);
        }

        // deleted equal users from array
        $usersAll = array_unique($usersAll);

        return $usersAll;
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
        $message    = $this->entityManager->getRepository(MessageTemplate::class)->find($messageId);

        $userIds    = isset($formData['user']) ? $formData['user'] : [];
        $groupIds   = isset($formData['groups']) ? $formData['groups'] : [];
        $users = $this->getUsers($userIds, $groupIds);

        foreach ($users as $user) {
            // create new object
            $object = new MessageUser();
            $object->setMessage($message);
            $object->setUser($user);
            parent::create($object);
        }
        return $object;
    }
}
