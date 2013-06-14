# To Do

These are the general topics I would like to improve.

## Core

* Rename all the database fields to use camel casing.
* Refactor the menu system. Use [nested sets](http://docs.cartalyst.com/nested-sets-2)?
* Refactor the module system
* Move Breadcrumb class out of Page module
* Refactor Inspector `inspect` method
* Possibly refactor user system?
* Refactor installer
* Use language files

## Modules

* Replace plugins with either "Services" or "Variables"
	* Service/Variable should be registered as singleton in Container
		* Useful for controller dependency
	* Service/Variable should be available in views

## Template

* Move to Blade layouts
* Remove current layout system

## Admin

* Add admin links in installer.
* Redo admin system?