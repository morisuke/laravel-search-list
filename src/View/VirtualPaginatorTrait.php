<?php

namespace Morisuke\SearchList\View;

/**
 * VirtualPaginatorTrait
 *
 * @package
 * @version $id$
 * @copyright itto.inc
 * @author morisuke <writers-high@outlook.com>
 * @license PHP Version 7.1
 */
trait VirtualPaginatorTrait
{
    /**
     * paginator
     *
     * @var AbstractPaginator
     * @access protected
     */
    protected $paginator;

    /**
     * __get
     *
     * @param mixed $name
     * @access public
     * @return void
     */
    public function __get($name)
    {
        return $this->paginator->{$name};
    }

    /**
     * count
     *
     * @access public
     * @return void
     */
    public function count()
    {
        return $this->paginator->count();
    }

    /**
     * __call
     *
     * @param mixed $method
     * @param mixed $params
     * @access public
     * @return void
     */
    public function __call($method, $params)
    {
        return $this->paginator->{$method}($params);
    }

    /**
     * getIterator
     *
     * @access public
     * @return void
     */
    public function getIterator()
    {
        return $this->paginator->getIterator();
    }

    /**
     * offsetExists
     *
     * @param mixed $offset
     * @access public
     * @return void
     */
    public function offsetExists($offset)
    {
        return $this->paginator->offsetExists($offset);
    }

    /**
     * offsetGet
     *
     * @param mixed $offset
     * @access public
     * @return void
     */
    public function offsetGet($offset)
    {
        return $this->paginator->offsetGet($offset);
    }

    /**
     * offsetSet
     *
     * @param mixed $offset
     * @param mixed $value
     * @access public
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        return $this->paginator->offsetSet($offset, $value);
    }

    /**
     * offsetUnset
     *
     * @param mixed $offset
     * @access public
     * @return void
     */
    public function offsetUnset($offset)
    {
        return $this->paginator->offsetUnset($offset);
    }
}
