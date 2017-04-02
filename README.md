# Laravel Search Paginator-List Module

## Description

本モジュールは設定値から検索フォームのHTMLを自動生成する機能と、  
そのフォームからsubmitされたgetパラメータを検索句としてQueryオブジェクトに適用する機能を提供する。

## Usage

### SearchRequestを継承したクラスを実装

articlesメソッドを実装し、設定項目を記述する。

```php
use App\Http\Requests\SearchRequest;

class ProductSearchRequest extends SearchRequest
{
	public function articles()
	{
		return [
			'name' => [
				'field'    => 'products.name',
				'type'     => 'text',
				'operator' => 'like'
			],
			'status' => [
				'field'   => 'products.status',
				'type'    => 'select',
				'options' => [
					1 => '公開',
					2 => '非公開',
					3 => '削除',
				],
			],
			'sales_start_date' => [
				'field'  => 'products.sales_start_date',
				'type'   => 'datetime-between',
				'filter' => function($query, $values) {
					return $query
					->where('sales_start_date', '>=', $values['before'])
					->where('sales_start_date', '<=', $values['after']);
				}
			],
		]
	}
}
```

### 検索対象のModelにSearchTraitを適用

Model::search\(SearchRequestInterface $request\) が付与される。

```php
use Morisuke\SearchList\Traits\SearchTrait;

class Products extends Model
{
	use SearchTrait;
}
```

### Controllerでタイプヒンティングに指定

$searchでタイプヒントしたクラスのインスタンスを取得できる。  
searchを呼び出すとQueryオブジェクトに検索条件が適用される。

最後にpaginateを呼び出すと**ListViewComponents**オブジェクトが取得される。

```php
use App\Models\Products;
use Morisuke\SearchList\Requests\Search\ProductSearchRequest;

class ProductsController extends Controller
{
	public function index(ProductSearchRequest $search)
	{
		return view('products.index', [
			'products' => Products::search($search)->paginate()
		]);
	}
}
```

### viewで検索ボックスをレンダリング

**ListViewComponents**オブジェクトはpaginatorインターフェイスを付与されている。  
内部で保持されるpaginatorは検索条件をappendsされているため、links\(\)を叩くだけでよい。

```php
// 検索ボックスをレンダリング
{{ $products->search() }}

// 検索条件の付与されたページネータをレンダリング
{{ $products->links() }}
```



