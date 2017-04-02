<?php

namespace Morisuke\SearchList\View;

use Illuminate\Contracts\Pagination\Paginator;

use Countable;
use ArrayAccess;
use IteratorAggregate;

/**
 * ListViewComponents
 *
 * @package
 * @version $id$
 * @copyright itto.inc
 * @author morisuke <writers-high@outlook.com>
 * @license PHP Version 7.1
 */
class ListViewComponents implements Countable, ArrayAccess, IteratorAggregate
{
    /**
     * To Paginator First Class
     */
    use VirtualPaginatorTrait;

    /**
     * search
     *
     * @var SearchViewInterface
     * @access public
     */
    public $search;

    /**
     * __construct
     *
     * @param AbstractPaginator $paginator
     * @access public
     * @return void
     */
    public function __construct(Paginator $paginator, SearchViewInterface $search)
    {
        $this->paginator = $paginator;
        $this->search    = $search;
    }

    /**
     * search
     *
     * @access public
     * @return void
     */
    public function search()
    {
        return $this->search->render();
    }
}
