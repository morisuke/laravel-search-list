<?php

namespace Morisuke\SearchList\Eloquent;

use Morisuke\SearchList\Http\Requests\SearchRequestInterface;
use Morisuke\SearchList\View\ListViewComponents;

/**
 * Builder
 *
 * @package
 * @version $id$
 * @copyright itto.inc
 * @author morisuke <writers-high@outlook.com>
 * @license PHP Version 7.1
 */
class Builder extends \Illuminate\Database\Eloquent\Builder
{
    /**
     * searchOperationを実装
     */
    use OperationTrait;

    /**
     * searchRequest
     *
     * @var SearchRequestInterface
     * @access protected
     */
    protected $searchRequest;

    /**
     * paginate
     *
     * @param mixed $perPage
     * @param string $columns
     * @param string $pageName
     * @param mixed $page
     * @access public
     * @return void
     */
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        // searchメソッドが実行されていない場合
        if (empty($this->searchRequest))
        {
            return parent::paginate($perPage, $columns, $pageName, $page);
        }

        // searchメソッドが実行されている場合はpaginateにappendしてListViewComponentsを返す
        $paginator = parent::paginate($perPage, $columns, $pageName, $page)->appends($this->searchRequest->input());
        return new ListViewComponents($paginator, $this->searchRequest->view());
    }

    /**
     * search
     *
     * @param SearchRequestInterface $search
     * @access public
     * @return void
     */
    public function search(SearchRequestInterface $search)
    {
        // articleを取得して検証
        foreach ($search->getArticles() as $name => $article)
        {
            // 値を取得
            $values = $search->input($name);

            // 値を取得出来ない、もしくはfiled名が指定されていない場合はcontinue
            if (($values !== 0 && $values !== '0' && empty($values)) || empty($article['field'])) continue;

            // filterメソッドが実装されているとき
            $method_name = camel_case($name) . 'Filter';
            if (method_exists($search, $method_name))
            {
                $search->{$method_name}($this, $values);
                continue;
            }

            // filterが設定されており、かつクロージャであるとき
            elseif (! empty($article['filter']) && is_callable($article['filter']))
            {
                $article['filter']($this, $values);
                continue;
            }

            // クエリをセット::SearchTrait
            $this->searchOperation($article['operator'], $article['field'], $values);
        }

        $this->searchRequest = $search;
        return $this;
    }
}
