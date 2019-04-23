<?php

namespace System;
class Application
{
    /*
     * Container
     *
     * @var array
     * */
    private  $contrainer = array();

    /*
    * Constructor
     *
     * @param \System\File
    */
    public function __construct($file)
    {
        $this->share('file',$file);
        $this->registerClasses();
        $this->loadHelpers();

        pre($this->file);
    }

    /*
     * Determine wehter the given file path exist
     *
     * @param string $file
     * @return bool
      */

    /*
    * Register classes in spl auto load register
    *
    * @return void
    */
    private function registerClasses()
    {
        spl_autoload_register([$this ,'load']);
    }

    /*
    * Load class through autoloading
     *
     * @param string $class
     * @return void
    */
    public function load($class)
    {
        if(strpos($class , 'App') === 0)
        {
            $file = $this->file->to($class.'.php');
        }
        else
        {
            // get the class from vendor
            $file = $this->file->toVendor($class.'.php');
        }
        if($this->file->exists($file))
        {
            $this->file->require($file);
        }
    }

    /*
    *  Load Helpers File
     *
     * @return Void
    */

    private function loadHelpers()
    {
        $this->file->require($this->file->toVendor('helpers.php'));
    }

    /*
    * Get shared Value
     *
     * @param String $key
     * @return mixed
    */
    public function get($key)
    {
        return isset($this->contrainer[$key])? $this->contrainer[$key] : null;
    }

    /*
    * Share given Key|Value Through the Application
     *
     * @param String $key
     * @param mixed $value
     * @return mixed
    */
    public function share($key,$value)
    {
        $this->contrainer[$key] = $value;
    }

    /*
    * Get Shared Value Dynamically
     *
     * @param String $key
     * $return mixed
    */
    public function __get($key)
    {
        return $this->get($key);
    }



}