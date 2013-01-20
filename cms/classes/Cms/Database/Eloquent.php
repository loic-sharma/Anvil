<?php namespace Cms\Database;

use Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Database\Eloquent\Model as IlluminateEloquent;

class Eloquent extends IlluminateEloquent {

	/**
	 * The model's validation rules.
	 *
	 * @var array
	 */
	public $rules = array();

	/**
	 * The validator instance.
	 *
	 * @var Illuminate\Validation\Validator
	 */
	protected $validator;

	/**
	 * Validate the model, and if it passes, save it to the database.
	 *
	 * @return bool
	 */
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

		// The validation passed, save the model.
		parent::save();

		return true;
	}

	/**
	 * Force the model to ignore the validation rules, and save
	 * to the database.
	 *
	 * @return void
	 */
	public function forceSave()
	{
		return parent::save();
	}

	/**
	 * Retrieve the validation errors.
	 *
	 * @return Illuminate\Support\MessageBag
	 */
	public function errors()
	{
		if( ! is_null($this->validator))
		{
			return $this->validator->errors();
		}

		else
		{
			// There are no errors, just return an empty
			// MessageBag.
			return new MessageBag;
		}
	}
}