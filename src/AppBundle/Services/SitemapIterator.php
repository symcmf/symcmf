<?php

namespace AppBundle\Services;

use Exporter\Source\SourceIteratorInterface;

class SitemapIterator implements SourceIteratorInterface
{
    protected $key;

    protected $current;

    public function current()
    {
        return $this->current;
    }

    public function next()
    {
        $this->key++;
        $this->current = array(
            'permalink'  => '/the/path/to/target',
            'lastmod'    => '',
            'changefreq' => 'weekly',
            'priority'   => 0.5
        );
    }

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

    public function rewind()
    {
        $this->key = 0;
    }
}
