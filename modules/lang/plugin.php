<?php

class LangPlugin extends Plugin {

	public function code()
	{
		
	}

	public function get(array $payload = array())
	{
		$line = $this->attributes('line', null);
		$default = $this->attributes('default', null);

		if( ! is_null($line))
		{
			unset($payload['line']);
			unset($payload['default']);

			Lang::get($line, $payload);
		}

		return $default;
	}
}