<?php

namespace Cms\Plugins;

use Illuminate\View\Environment as ViewEnvironment;

class Facade {

	protected $plugin;

	public function __construct(Plugin $plugin)
	{
		$this->plugin = $plugin;
	}

	public function __get($key)
	{
		return $this->plugin->$key;
	}

	public function __set($key, $value)
	{
		$this->plugin->$key = $value;
	}

	public function __call($method, $args)
	{
		if(count($args) == 1)
		{
			if(is_array($args[0]))
			{
				$this->plugin->setAttributes($args[0]);
			}

			return $this->plugin->$method($args[0]);
		}

		else
		{
			switch (count($args))
			{
				case 0:
					return $this->plugin->$method();

				case 2:
					return $this->plugin->$method($args[0], $args[1]);

				case 3:
					return $this->plugin->$method($args[0], $args[1], $args[2]);

				case 4:
					return $this->plugin->$method($args[0], $args[1], $args[2], $args[3]);

				default:
					return call_user_func_array(array($this->plugin, $method), $args);
			}
		}
	}
}