<?php

class LangPlugin extends Plugin {

	/**
	 * Get a language line.
	 *
	 * @param  string  $line
	 * @param  array   $payload
	 * @return mixed
	 */
	public function get($line, array $payload = array())
	{
		if( ! is_null($line = $this->attribute('line', null)))
		{
			return Lang::get($line, $payload);
		}

		// If no line was given, just return the default
		// if one was inputted, or just null.
		else
		{
			return $this->attribute('default', null);
		}
	}
}