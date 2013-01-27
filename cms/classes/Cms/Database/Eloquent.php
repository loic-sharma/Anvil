<?php namespace Cms\Database;

use Hash;
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
	 * The fields to hash before saving.
	 *
	 * @var array
	 */
	protected $hash = array();

	/**
	 * Validate the model, and if it passes, save it to the database.
	 *
	 * @return bool
	 */
	public function save()
	{
		$this->validator = Validator::make($this->attributes, $this->rules);

		if($this->validator->fails())
		{
			return false;
		}
		
		else
		{
			$this->forceSave();

			return true;
		}
	}

	/**
	 * Force the model to ignore the validation rules, and save
	 * to the database.
	 *
	 * @return void
	 */
	public function forceSave()
	{
		$this->hashAttributes();
		$this->removeConfirmationAttributes();

		return parent::save();
	}

	/**
	 * Hash attribrutes that are stored as hash.
	 *
	 * @return void
	 */
	public function hashAttributes()
	{
		foreach($this->hash as $attribute)
		{
			$this->attributes[$attribute] = Hash::make($this->attributes[$attribute]);
		}
	}

	/**
	 * Remove the attributes used to confirm field values.
	 *
	 * @return void
	 */
	public function removeConfirmationAttributes()
	{
		foreach($this->attributes as $key => $value)
		{
			if(strpos($key, '_confirmation') !== false)
			{
				$confirmedField = substr($key, 0, -13);

				if(isset($this->attributes[$confirmedField]))
				{
					unset($this->attributes[$key]);
				}
			}
		}
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