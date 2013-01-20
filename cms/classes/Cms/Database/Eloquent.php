<?php namespace Cms\Database;

use Illuminate\Validation\Validator;
use Illuminate\Database\Eloquent\Model as IlluminateEloquent;

class Eloquent extends IlluminateEloquent {

	public $rules = array();

	protected $validator;

	public function save()
	{
		if( ! empty($this->rules))
		{
			$this->validator = Validator::make($this->attributes, $this->rules);

			if($this->validator->fails())
			{
				return false;
			}
		}

		parent::save();

		return true;
	}

	public function forceSave()
	{
		return parent::save();
	}

	public function errors()
	{
		if( ! is_null($this->validator))
		{
			return $this->validator->errors();
		}

		else
		{
			return array();
		}
	}
}