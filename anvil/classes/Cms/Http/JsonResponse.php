<?php namespace Cms\Http;

use Illuminate\Support\Contracts\JsonableInterface;

class JsonResponse implements JsonableInterface {

	/**
	 * The response's data.
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Add the response's data.
	 *
	 * @param  array  $data
	 * @return void
	 */
	public function __construct(array $data = array())
	{
		$this->data = $data;
	}

	/**
	 * Convert the instance to JSON.
	 *
	 * @param  int  $options
	 * @return string
	 */
	public function toJson($options = JSON_NUMERIC_CHECK)
	{
		return json_encode($this->data, $options);
	}

}