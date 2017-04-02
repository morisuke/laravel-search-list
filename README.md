# Laravel Pagination Search Module

## Description

This module provides the function to automatically generate the search form HTML from the setting value and the function to apply the get parameter submitted from the form to the Query object as a search phrase.

## Usage

### Implement class inheriting SearchRequest

Implement the articles method and describe the setting.

```php
use Morisuke\SearchList\Http\Requests\SearchRequest;

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
					1 => 'public',
					2 => 'private',
					3 => 'remove',
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

### Apply SearchTrait to the search target model

Model::search\(SearchRequestInterface $request\) is given.

```php
use Morisuke\SearchList\Traits\SearchTrait;

class Products extends Model
{
	use SearchTrait;
}
```

### Designate type hinting with Controller

You can get instances of classes typed with $search.  
When search is called, the search condition is applied to the Query object.

Finally calling paginate will get the ** ListViewComponents ** object.

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

### Render search box

** ListViewComponents ** Objects are given a paginator interface.  
Since the paginator held internally is appends to the search condition, it is enough to hit links \(\).

```php
// Render search box
{{ $products->search() }}

// Render the paginator given the search condition
{{ $products->links() }}
```



