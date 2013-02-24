<?php namespace Anvil\Settings;

use Illuminate\Database\DatabaseManager;

class DatabaseLoader implements LoaderInterface {

	/**
	 * The current Database connection.
	 *
	 * @var Illuminate\Database\DatabaseManager
	 */
	protected $database;

	/**
	 * The current settings.
	 *
	 * @var array
	 */
	protected $settings = array();

	/**
	 * Create a new DatabaseLoader instance.
	 *
	 * @param  Illuminate\Database\DatabaseManager  $database
	 * @return void
	 */
	public function __construct(DatabaseManager $database)
	{
		$this->database = $database;
	}

	/**
	 * Retrieve the current settings.
	 *
	 * @return array
	 */
	public function get()
	{
		if(empty($this->settings))
		{
			$settings = $this->database->table('settings')->get();

			foreach($settings as $setting)
			{
				$this->settings[$setting->key] = unserialize($setting->value);
			}
		}

		return $this->settings;
	}

	/**
	 * Save the new settings.
	 *
	 * @param  array  $settings
	 * @return array
	 */
	public function save(array $settings)
	{
		foreach($settings as $key => $value)
		{
			// Only settings that have changed will be saved.
			if(isset($this->settings[$key]) and $this->settings[$key] != $value)
			{
				$value = serialize($value);

				$this->database->table('settings')
					->where('key', '=', $key)
					->update(compact('value'));
			}

			else
			{
				$this->database->table('settings')
					->insert(compact('key', 'value'));
			}
		}

		// Save the new settings locally in case new settings are saved.
		$this->settings = $settings;
	}
}