<?php

namespace AppBundle\Services;

use Exporter\Source\SourceIteratorInterface;

/**
 * Class SitemapIterator
 * @package AppBundle\Services
 */
class SitemapIterator implements SourceIteratorInterface
{
    /**
     * @var integer
     */
    protected $key;

    /**
     * @var array
     */
    protected $current;

    /**
     * @return array
     */
    public function current()
    {
        return $this->current;
    }

    /**
     * Method for getting next object
     */
    public function next()
    {
        $this->key++;
        $this->current = [
            'permalink'  => '',
            'lastmod'    => '',
            'changefreq' => 'weekly',
            'priority'   => 0.5
        ];
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        return (null !== $this->current);
    }

    /**
     * Method for rewind
     */
    public function rewind()
    {
        $this->key = 0;
    }
}
