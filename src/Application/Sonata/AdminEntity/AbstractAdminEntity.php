<?php
namespace Application\Sonata\AdminEntity;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;

class AbstractAdminEntity extends AbstractAdmin
{
    /**
     * @var
     */
    protected $service = null;

    /**
     * @var array
     */
    protected $listFields = [];

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        foreach ($this->listFields as $item) {
            $listMapper->add($item);
        }
    }
}
