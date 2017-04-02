<?php

namespace Morisuke\SearchList\Http\Requests;

use Generator;
use Illuminate\Foundation\Http\FormRequest;
use Morisuke\SearchList\View\SearchView;

/**
 * SearchRequest
 *
 * @uses FormRequest
 * @abstract
 * @package
 * @version $id$
 * @copyright itto.inc
 * @author morisuke <writers-high@outlook.com>
 * @license PHP Version 7.1
 */
abstract class SearchRequest extends FormRequest implements SearchRequestInterface
{
    /**
     * article
     *
     * @abstract
     * @access public
     * @return array
     */
    abstract public function articles(): array;

    /**
     * type => default_operator
     */
    const DEFAULT_OPERATOR = [
        'text'     => '=',
        'check'    => 'in',
        'radio'    => '=',
        'select'   => '=',
        'datetime' => '=',
    ];

    /**
     * getArticles
     *
     * @access public
     * @return void
     */
    public function getArticles(): Generator
    {
        foreach ($this->articles() as $name => $article)
        {
            if (empty($article['operator']))
            {
                $article['operator'] = static::DEFAULT_OPERATOR[$article['type']] ?? '=';
            }

            if (empty($article['label']))
            {
                list ($table_name, $field_name) = explode('.', $article['field'] ?? '');
                $table_name       = str_singular($table_name);
                $article['label'] = "{$table_name}.{$field_name}";
            }

            yield $name => $article;
        }
    }

    /**
     * render
     *
     * @access public
     * @return void
     */
    public function view()
    {
        return new SearchView($this);
    }

    /**
     * rules
     *
     * @access public
     * @return void
     */
    public function rules()
    {
        return [];
    }

    /**
     * authorize
     *
     * @access public
     * @return void
     */
    public function authorize()
    {
        return true;
    }
}
