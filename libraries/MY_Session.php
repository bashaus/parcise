<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session
{
	
	function __construct()
	{
		$this->sess_use_database = false;
		parent::__construct();
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch the current session data if it exists
	 *
	 * @access	public
	 * @return	bool
	 */
	function sess_read()
	{
		if (!parent::sess_read())
		{
			return false;
		}

		$session = Session::find(array(
			'conditions' => array(
				'session_id = ? AND ip_address = ? AND user_agent = ?',
				$this->userdata['session_id'],
				$this->userdata['ip_address'],
				$this->userdata['user_agent']
			)
		));

		// No result?  Kill it!
		if (!$session)
		{
			$this->sess_destroy();
			return false;
		}

		// Is there custom data?  If so, add it to the main session array
		if (isset($session->user_data) AND $session->user_data != '')
		{
			$custom_data = $this->_unserialize($session->user_data);

			if (is_array($custom_data))
			{
				foreach ($custom_data as $key => $val)
				{
					$this->userdata[$key] = $val;
				}
			}
		}

		return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Write the session data
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_write()
	{
		// set the custom userdata, the session data we will set in a second
		$custom_userdata = $this->userdata;
		$cookie_userdata = array();

		// Before continuing, we need to determine if there is any custom data to deal with.
		// Let's determine this by removing the default indexes to see if there's anything left in the array
		// and set the session data while we're at it
		foreach (array('session_id','ip_address','user_agent','last_activity') as $val)
		{
			unset($custom_userdata[$val]);
			$cookie_userdata[$val] = $this->userdata[$val];
		}

		// Did we find any custom data?  If not, we turn the empty array into a string
		// since there's no reason to serialize and store an empty array in the DB
		if (count($custom_userdata) === 0)
		{
			$custom_userdata = '';
		}
		else
		{
			// Serialize the custom data array so we can store it
			$custom_userdata = $this->_serialize($custom_userdata);
		}

		// Run the update query
		$set = array(
			'user_data'     => $custom_userdata,
			'last_activity' => $this->userdata['last_activity']
		);

		Session::table()->update(
			$set,
			array('session_id' => $this->userdata['session_id'])
		);

		// Write the cookie.  Notice that we manually pass the cookie data array to the
		// _set_cookie() function. Normally that function will store $this->userdata, but
		// in this case that array contains custom data, which we do not want in the cookie.
		$this->_set_cookie($cookie_userdata);
	}

	// --------------------------------------------------------------------

	/**
	 * Create a new session
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_create()
	{
		parent::sess_create();

		$session = new Session;
		$session->set_attributes($this->userdata);
		$this->last_activity = $this->now;
		$session->save();
	}

	// --------------------------------------------------------------------

	/**
	 * Update an existing session
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_update()
	{
		// We only update the session every five minutes by default
		if (($this->userdata['last_activity'] + $this->sess_time_to_update) >= $this->now)
		{
			return;
		}

		// Find the session information
		$old_sessid = $this->userdata['session_id'];
		parent::sess_update();
		$new_sessid = $this->userdata['session_id'];

		$set = array(
			'session_id' => $new_sessid,
			'last_activity' => $this->now
		);

		Session::table()->update(
			$set,
			array('session_id' => $old_sessid)
		);
	}

	// --------------------------------------------------------------------

	/**
	 * Destroy the current session
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_destroy()
	{
		Session::table()->delete(array('session_id' => $this->userdata['session_id']));
		parent::sess_destroy();
	}


	// --------------------------------------------------------------------

	/**
	 * Garbage collection
	 *
	 * This deletes expired session rows from database
	 * if the probability percentage is met
	 *
	 * @access	public
	 * @return	void
	 */
	function _sess_gc()
	{
		srand(time());
		if ((rand() % 100) < $this->gc_probability)
		{
			$expire = $this->now - $this->sess_expiration;

 			Session::delete_all(array('conditions' => array('last_activity < ?', $expire)));

			log_message('debug', 'Session garbage collection performed.');
		}
	}
}