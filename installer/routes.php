<?php

Route::get('/', function()
{
	$errors = array();

	// Check requirements.
	$base = dirname(dirname(__FILE__));

	$paths = array(
		$base . '/anvil/storage/cache/',
		$base . '/anvil/storage/logs/',
		$base . '/anvil/storage/meta/',
		$base . '/anvil/storage/sessions/',
		$base . '/anvil/storage/views/',
	);

	foreach($paths as $path)
	{
		if( ! is_writable($path))
		{
			$errors[] = $path . ' must be writable.';
		}
	}

	return View::make('requirements', compact('errors'));
});

Route::get('step-2', function()
{
	return View::make('database');
});

Route::post('step-2', function()
{
	$form = Validator::make($input = Input::all(), array(
		'hostname' => array('required'),
		'username' => array('required'),
		'password' => array('required'),
		'database' => array('required'),
	));

	if($form->passes())
	{
		$search = array_map(function($key)
		{
			return '{{'.$key.'}}';

		}, array_keys($input));

		$replace = array_values($input);

		$stub = File::get(__DIR__.'/stubs/database.php');

		$stub = str_replace($search, $replace, $stub);

		File::put(__DIR__.'/../config/database.php', $stub);

		return Redirect::to('step-3');
	}

	else
	{
		return Redirect::to('step-2')->withErrors($form);
	}
});

Route::get('step-3', function()
{
	Schema::dropIfExists('comments');

	Schema::create('comments', function($table)
	{
		$table->increments('id');

		$table->integer('author_id');
		$table->integer('post_id');
		$table->string('area')->nullable();
		$table->text('content')->nullable();

		$table->timestamps();
	});

	Schema::dropIfExists('groups');

	Schema::create('groups', function($table)
	{
		$table->increments('id');

		$table->string('name')->nullable();
		$table->integer('power')->default(0);
		$table->text('permissions')->nullable();
	});

	Schema::dropIfExists('modules');

	Schema::create('modules', function($table)
	{
		$table->increments('id');

		$table->string('slug')->unique();
		$table->integer('enabled')->default(0);
		$table->integer('installed')->default(0);
		$table->integer('is_core')->default(0);
	});

	Schema::dropIfExists('navigation_links');

	Schema::create('navigation_links', function($table)
	{
		$table->increments('id');

		$table->integer('menu_id');
		$table->integer('parent_id')->nullable();
		$table->string('title')->nullable();
		$table->string('url')->nullable();
		$table->integer('required_power')->nullable();
		$table->integer('max_power')->nullable();
	});

	Schema::dropIfExists('navigation_menus');

	Schema::create('navigation_menus', function($table)
	{
		$table->increments('id');

		$table->string('slug')->unique();
		$table->string('title')->nullable();
	});

	Schema::dropIfExists('pages');

	Schema::create('pages', function($table)
	{
		$table->increments('id');

		$table->string('slug')->unique();
		$table->string('title')->nullable();
		$table->string('layout')->nullable();
		$table->text('content')->nullable();
		$table->integer('comments_enabled')->default(1);

		$table->timestamps();
	});

	Schema::dropIfExists('permissions');

	Schema::create('permissions', function($table)
	{
		$table->increments('id');

		$table->string('slug')->unique();
		$table->string('name')->nullable();
		$table->integer('required_power')->nullable();
		$table->integer('max_power')->nullabe();
	});

	Schema::dropIfExists('posts');

	Schema::create('posts', function($table)
	{
		$table->increments('id');

		$table->integer('author_id');
		$table->string('title');
		$table->text('content');
		$table->integer('comments_enabled');

		$table->timestamps();
	});

	Schema::dropIfExists('settings');

	Schema::create('settings', function($table)
	{
		$table->increments('id');

		$table->string('key');
		$table->text('value')->nullable();
	});

	Schema::dropIfExists('users');

	Schema::create('users', function($table)
	{
		$table->increments('id');

		$table->integer('group_id')->nullable();
		$table->string('email');
		$table->string('password');
		$table->text('permissions')->nullable();
		$table->string('first_name')->nullable();
		$table->string('last_name')->nullable();

		$table->timestamps();
	});

	DB::table('modules')->insert(array(
		array(
			'slug' => 'blog',
			'enabled' => 1,
			'installed' => 1,
			'is_core' => 1
		),
		array(
			'slug' => 'users',
			'enabled' => 1,
			'installed' => 1,
			'is_core' => 1
		),
		array(
			'slug' => 'navigation',
			'enabled' => 1,
			'installed' => 1,
			'is_core' => 1
		),
		array(
			'slug' => 'page',
			'enabled' => 1,
			'installed' => 1,
			'is_core' => 1
		),
		array(
			'slug' => 'settings',
			'enabled' => 1,
			'installed' => 1,
			'is_core' => 1
		),
		array(
			'slug' => 'lang',
			'enabled' => 1,
			'installed' => 1,
			'is_core' => 1
		),
		array(
			'slug' => 'theme',
			'enabled' => 1,
			'installed' => 1,
			'is_core' => 1
		),
		array(
			'slug' => 'modules',
			'enabled' => 1,
			'installed' => 1,
			'is_core' => 1
		),
		array(
			'slug' => 'comments',
			'enabled' => 1,
			'installed' => 1,
			'is_core' => 1
		),
	));

	DB::table('settings')->insert(array(
		array(
			'key' => 'defaultController',
			'value' => serialize('BlogController'),
		),
		array(
			'key' => 'theme',
			'value' => serialize('bootstrap'),
		),
		array(
			'key' => 'title',
			'value' => serialize('My Website'),
		),
	));

	DB::table('groups')->insert(array(
		array(
			'name'        => 'guest',
			'power'       => 0,
			'permissions' => NULL,
		),
		array(
			'name'        => 'user',
			'power'       => 1,
			'permissions' => NULL,
		),
		array(
			'name'        => 'moderator',
			'power'       => 50,
			'permissions' => NULL,
		),
		array(
			'name'        => 'admin',
			'power'       => 100,
			'permissions' => serialize(array('access_admin_panel' => true)),
		),
	));

	DB::table('posts')->insert(array(
		'author_id' => 1,
		'title' => 'Hello World!',
		'content' => 'Welcome to your blog!',
		'comments_enabled' => 1,
	));

	DB::table('navigation_menus')->insert(array(
		array(
			'slug'  => 'header',
			'title' => 'Header',
		),
		array(
			'slug'  => 'sidebar',
			'title' => 'Sidebar',
		),
		array(
			'slug'  => 'admin',
			'title' => 'Admin',
		),
	));

	DB::table('navigation_links')->insert(array(
		array(
			'menu_id'   => 1,
			'parent_id' => NULL,
			'title'     => 'Home',
			'url'       => '{url}/',
			'max_power' => NULL,
			'required_power' => NULL,
		),
		array(
			'menu_id'   => 1,
			'parent_id' => NULL,
			'title'     => 'Contact',
			'url'       => '{url}/page/contact',
			'max_power' => NULL,
			'required_power' => NULL,
		),
		array(
			'menu_id'   => 2,
			'parent_id' => NULL,
			'title'     => 'User Control Panel',
			'url'       => '{url}/profile',
			'max_power' => NULL,
			'required_power' => 1,
		),
		array(
			'menu_id'   => 2,
			'parent_id' => NULL,
			'title'     => 'Admin Control Panel',
			'url'       => '{adminUrl}/',
			'max_power' => NULL,
			'required_power' => 100,
		),
		array(
			'menu_id'   => 2,
			'parent_id' => NULL,
			'title'     => 'Logout',
			'url'       => '{url}/logout',
			'max_power' => NULL,
			'required_power' => 1,
		),
		array(
			'menu_id'   => 2,
			'parent_id' => NULL,
			'title'     => 'Login',
			'url'       => '{url}/login',
			'max_power' => 0,
			'required_power' => NULL,
		),
	));

	return Redirect::to('step-4');
});

Route::get('step-4', function()
{
	return View::make('create_admin');
});

Route::post('step-4', function()
{
	$form = Validator::make(Input::all(), array(
		'email'    => array('required', 'email'),
		'password' => array('required', 'confirmed'),
	));

	if($form->passes())
	{
		DB::table('users')->insert(array(
			'group_id' => 4,
			'email' => 'admin@example.com',
			'password' => Hash::make('admin'),
			'first_name' => 'John',
			'last_name' => 'Doe',
		));

		Auth::attempt(array(
			'email' => 'admin@example.com',
			'password' => 'admin',
		));

		return Redirect::to('/../../');	
	}

	return Redirect::to('step-4')->withErrors($form);
});