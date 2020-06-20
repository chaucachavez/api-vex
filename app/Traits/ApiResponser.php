<?php 


namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{
	private function successResponse($data, $code)
	{	
		
		return response()->json($data, $code);
	}

	protected function errorResponse($message, $code, $optional = '')
	{
		return response()->json(['error' => $message, 'code' => $code, 'optional' => $optional], $code);
	}

	//Collection
	protected function showAll($collection, $code = 200)
	{	  

		//dd($collection->first());

		//$collection = $this->filterData($collection, $collection->first()->getFillable()); 
		//$collection = $this->sortData($collection);  
		//$collection = $this->paginate($collection); 
		//$collection = $this->cacheResponse($collection); 
		
		return $this->successResponse(['data' => $collection], $code);
		//return $this->successResponse($collection, $code);
	}

	protected function showPaginateAll($data, $code = 200)
	{	//LengthAwarePaginator  

		//dd($collection->first()); 
		//$collection = $this->filterData($collection, $collection->first()->getFillable()); 
		//$collection = $this->sortData($collection);  
		//$collection = $this->paginate($collection); 
		//$collection = $this->cacheResponse($collection); 
		
		//return $this->successResponse(['data' => $collection], $code); 
		if (!$data instanceof LengthAwarePaginator)
			$data = array('data' => $data);

		return $this->successResponse($data, $code);
	}

	protected function showOne(Model $instance, $code = 200)
	{	
		// dd('hola');
		return $this->successResponse(['data' => $instance], $code);
	}

	protected function showMessage($message, $code = 200, $indice = 'data') 
	{
		return $this->successResponse([$indice => $message], $code);
	}

	protected function filterData($collection, $fillable)
	{ 
		foreach (request()->query() as $query => $value) {
			$attribute = $query;

			if (isset($attribute, $value) && in_array($attribute, $fillable)) {
				//dd($attribute, $value);
				$collection = $collection->where($attribute, $value);
			}
		}

		return $collection;
	}

	protected function sortData(Collection $collection) 
	{	


		//Helper request()
		if(request()->has('sort_by')) {
			$attribute = request()->sort_by;

			//$collection = $collection->sortBy($attribute);
			//En 5.3 se incluyó mensajes de alto nivel en las colecciones.			
			$collection = $collection->sortBy->{$attribute};
			
			//El método all devuelve la matriz subyacente representada por la colección:
			//El método values devuelve una nueva colección con las claves restablecidas en enteros consecutivos:
			$collection = $collection->values()->all();
		} 

		return $collection;
	}

	protected function paginate(Collection $collection) 
	{

		$rules = [
			'per_page' => 'integer|min:2|max:50'
		];

		Validator::validate(request()->all(), $rules);

		$page = LengthAwarePaginator::resolveCurrentPage();

		$perPage = 5;
		if (request()->has('per_page')) {
			$perPage = (int) request()->per_page;
		}

		$results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

		$paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
			'path' => LengthAwarePaginator::resolveCurrentPage(),			
		]);

		$paginated->appends(request()->all()); 

		return $paginated;
	}
 
	protected function cacheResponse($data) 
	{
		$url = request()->url(); 
		$queryParams = request()->query(); 

		ksort($queryParams); 

		$queryString = http_build_query($queryParams);

		$fullUrl = "{$url}?{$queryString}";
		// 15/60, 15 min entre 60 minutos
		return Cache::remember($fullUrl, 30/60, function() use($data) {
			return $data;
		});  
	}
}