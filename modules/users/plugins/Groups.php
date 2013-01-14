<?php

class GroupsPlugin {

	public function get()
	{
		return Group::all();
	}
}