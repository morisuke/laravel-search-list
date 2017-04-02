<?php

namespace Morisuke\SearchList\Http\Requests;

use Generator;

/**
 * SearchRequestInterface
 *
 * @package
 * @version $id$
 * @copyright itto.inc
 * @author morisuke <writers-high@outlook.com>
 * @license PHP Version 7.1
 */
interface SearchRequestInterface
{
    /**
     * article
     *
     * @access public
     * @return array
     */
    public function articles(): array;

    /**
     * getArticles
     *
     * @access public
     * @return Generator
     */
    public function getArticles(): Generator;

    /**
     * view
     *
     * @access public
     * @return void
     */
    public function view();
}
