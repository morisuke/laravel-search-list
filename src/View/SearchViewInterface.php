<?php

namespace Morisuke\SearchList\View;

use Illuminate\Support\HtmlString;
use Morisuke\SearchList\Http\Requests\SearchRequestInterface;
use Generator;

/**
 * SearchViewInterface
 *
 * @package
 * @version $id$
 * @copyright itto.inc
 * @author morisuke <writers-high@outlook.com>
 * @license PHP Version 7.1
 */
interface SearchViewInterface
{
    /**
     * __construct
     *
     * @param SearchRequest $request
     * @access public
     * @return void
     */
    public function __construct(SearchRequestInterface $request);


    /**
     * getRenderSettings
     *
     * ex) yield $blade_template_name => $vars
     *
     * @access public
     * @return Generator
     */
    public function getRenderSettings(): Generator;

    /**
     * all
     *
     * ex) yield new HtmlString($html);
     *
     * @access public
     * @return Generator
     */
    public function all(): Generator;

    /**
     * render
     *
     * @param string $action
     * @access public
     * @return HtmlString
     */
    public function render(string $action = null): HtmlString;
}
