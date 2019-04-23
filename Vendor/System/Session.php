<?php

/*
 * Session Class
 *
 *
 * Prerequistites
 *
 * Basic Seasion Handling
 *
 *
 * Session ::start  Start Session
 * Session ::set  Add new value to  Session
 * Session ::get  get new value from Session
 * Session ::has  determine if session has the given key
 * Session ::remove  remove the given key from Session
 * Session ::all    get all session data
 * Session ::pull  get the value of the given key and remove it
 *
*/


namespace System;


class Session
{
    /*
    * Application Object
     *
     * @var \System\Application
    */
    private $app;


    /*
    * Constructor
     *
     * @param \System\Application
    */

    public function __construct(Application $app)
    {
        $this->app=$app;
    }
    /*
     * Start Session
     *
     * @return void
     *  */
    public function start()
    {
        init_set_('session.use_only_cookies' , 1);
        if(! session_id())
        {
            session_start();
        }
    }

    /*
     * Set new Value to Session
     *
     * @param string $key
     * @param mixed $value
     * return void
     * */
    public function set($key,$value)
    {
        $_SESSION[$key]=$value;
    }

    /*
     * get value from session by the given key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     * */
    public function get($key,$default = null)
    {

        return array_get($_SESSION,$key,$default);
    }

    /*
     * Determine if the session has the given key
     *
     * @param string $key
     * @return bool
     * */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /*
     * Remove the given key from session
     *
     * @param string $key
     * @return void
     * */
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /*
     * Get value from Session by the given key then remove it
     *
     * @param string $key
     * @return mixed
     * */
    public function pull($key)
    {
        $value = $this->get($key);
        $this->remove($key);
        return $value;
    }

    /*
     * get all session data
     *
     * @return array
     * */
    public function all()
    {
        return $_SESSION;
    }

    /*
     * Destory Session
     *
     * @return void
     * */
    public function destory()
    {
        session_destroy();
        unset($_SESSION);
    }

}