<?php

namespace MessageBundle\Entity;

use MessageBundle\Model\MessageTemplateManagerInterface;
use Sonata\CoreBundle\Model\BaseEntityManager;
use Sonata\DatagridBundle\Pager\Doctrine\Pager;
use Sonata\DatagridBundle\ProxyQuery\Doctrine\ProxyQuery;

class MessageTemplateManager extends BaseEntityManager implements MessageTemplateManagerInterface
{
    /**
     * @param array $criteria
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @return Pager
     */
    public function getPager(array $criteria, $page, $limit = 10, array $sort = array())
    {
        $query = null;

        $pager = new Pager();
        $pager->setMaxPerPage($limit);
        $pager->setQuery(new ProxyQuery($query));
        $pager->setPage($page);
        $pager->init();
        return $pager;
    }
}
