<?php

class PermissionsPlugin {

	public function get()
	{
		return Permission::all();
	}
}