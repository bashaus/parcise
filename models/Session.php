<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session extends ActiveRecord\Model
{

	function __construct()
	{
		call_user_func_array(array('parent', '__construct'), func_get_args());
	}
}