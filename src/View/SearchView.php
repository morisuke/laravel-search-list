<?php

namespace Morisuke\SearchList\View;

use Illuminate\Support\HtmlString;
use Morisuke\SearchList\Http\Requests\SearchRequestInterface;
use Generator;

/**
 * SearchView
 *
 * @package
 * @version $id$
 * @copyright itto.inc
 * @author morisuke <writers-high@outlook.com>
 * @license PHP Version 7.1
 */
class SearchView implements SearchViewInterface
{
    /**
     * Where the template is module
     */
    const TEMPLATE_MODULE_NAME = 'search';

    /**
     * Where the template is directory
     */
    const TEMPLATE_DIRECTORY_NAME = '';

    /**
     * searchRequest
     *
     * @var SearchRequest
     * @access protected
     */
    protected $searchRequest = null;

    /**
     * __construct
     *
     * @param SearchRequest $request
     * @access public
     * @return void
     */
    public function __construct(SearchRequestInterface $request)
    {
        // プロパティにインスタンスを保持
        $this->searchRequest = $request;
    }

    /**
     * getRenderSettings
     *
     * @access public
     * @return void
     */
    public function getRenderSettings(): Generator
    {
        // 設定項目を取り出してテンプレートに渡すべき形に編集
        foreach ($this->searchRequest->getArticles() as $name => $article)
        {
            // $articleからテンプレート名を特定
            $blade_name = $this->getBladeTemplateName($article);

            // optionsをメソッドから取得できないか試行する
            $method_name = camel_case($name) . 'Options';
            if (method_exists($this->searchRequest, $method_name))
            {
                $article['options'] = $this->searchRequest->{$method_name}();
            }

            // テンプレートに渡す変数を列挙
            $vars = [
                'name'    => $name,
                'value'   => $this->searchRequest->input($name),
                'label'   => $article['label'],
                'field'   => $article['field'] ?? null,
                'options' => $article['options'] ?? [],
            ];

            yield $blade_name => $vars;
        }
    }

    /**
     * all
     *
     * @access public
     * @return Generator
     */
    public function all(): Generator
    {
        // 設定からHtmlStringオブジェクトを生成
        foreach ($this->getRenderSettings() as $template_name => $vars)
        {
            yield new HtmlString(view($template_name, $vars)->render());
        }
    }

    /**
     * render
     *
     * @param string $action
     * @access public
     * @return HtmlString
     */
    public function render(string $action = null): HtmlString
    {
        $renders = [];
        foreach($this->all() as $view)
        {
            $renders[] = $view->toHtml();
        }

        // コンテナに詰める
        $container = view($this->generateBladeTemplateName('container'), ['contents' => new HtmlString(implode('', $renders)), 'action' => $action]);

        // 全てのHtmlStringオブジェクトを一括でレンダリング
        return new HtmlString($container->render());
    }


    /**
     * getBladeTemplateName
     *
     * @param array $article
     * @access protected
     * @return void
     */
    protected function getBladeTemplateName(array $article): string
    {
        $type     = $article['type'] ?? null;
        $operator = $article['operator'] ?? null;

        // 特殊なテンプレート名を取得
        $ex_operations = config('search.extended_template_operations') ?? [];
        $ex_type       = $ex_operations["{$type}.{$operator}"] ?? null;
        if (! empty($ex_type))
        {
            return $this->generateBladeTemplateName("form.{$ex_type}");
        }

        // テンプレート名を返却
        return $this->generateBladeTemplateName("form.{$type}");
    }

    /**
     * generateTemplateName
     *
     * @param string $template_name
     * @access protected
     * @return string
     */
    protected function generateBladeTemplateName(string $template_name): string
    {
        $template_module    = config('search.template_module') ?? static::TEMPLATE_MODULE_NAME;
        $template_directory = config('search.template_directory') ?? static::TEMPLATE_DIRECTORY_NAME;

        return implode('::', array_filter([
            $template_module,
            implode('.', array_filter([
                $template_directory,
                $template_name
            ], 'strlen')),
        ], 'strlen'));
    }
}
