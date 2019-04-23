<?php

namespace System;
class Application
{
    /*
     * Container
     *
     * @var array
     * */
    private  $contrainer = array();  // array of Key|Value example ('file' key -> FileSystem Value)

    /*
    * Constructor
     *
     * @param \System\File
    */
    public function __construct($file)
    {
        $this->share('file',$file);   // Insert into Array through Function Shared Key|Value
        $this->registerClasses();     // Auto Include for Classes
        $this->loadHelpers();         // Helper Function example pre -> (echo "<pre>" print_r($var) echo "</pre>"
    }
    /*
    *   run the Application
     *
     * @return void
    */
    public function run()
    {
        $this->session->start();
        $this->request->prepareUrl();
    }


    /*
    * Register classes in spl auto load register
    *
    * @return void
    */
    private function registerClasses()
    {
        spl_autoload_register([$this ,'load']);        // Load class function with $this->load
    }

    /*
    * Load class through autoloading
     *
     * @param string $class
     * @return void
    */
    public function load($class)
    {
        if(strpos($class , 'App') === 0)           // Strpos(string , Find , Start =Optinal) return position of string if 'app' is postion 0 t
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
        if(! $this->isSharing($key))
        {
            if($this->isCoreAlias($key))
            {
                $this->share($key,$this->createNewCoreObject($key));
            }
            else
            {
                die('<b>'.$key .'</b> Not Fount in application container');
            }
        }
        return $this->contrainer[$key];
    }


    /*
    *   Determine if the given key is shared through Application
     *
     * @param string $king
     * @return bool
    */
    public function isSharing($key)
    {
        return isset($this->contrainer[$key]);
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
   *   Determine if the given key is Alias to core classs
   *
   * @param string $king
   * @return bool
  */
    public function isCoreAlias($alias)
    {
        $coreClasses = $this->coreClasses();
        return isset($coreClasses[$alias]);
    }


    /*
   * Create new Object for the core class based on the given alias
   *
   * @param String $alias
   * @return $object
  */
    public function createNewCoreObject($alias)
    {
        $coreClass = $this->coreClasses();
        $object = $coreClass[$alias];
        return new $object($this);       //created Object !
    }

    /*
        * get all core classes with its aliases
     *
     * @return array
    */
    private function coreClasses()
    {
        return
            [
            'request'    =>  'System\\Http\\Request',
            'response'   =>  'System\\Http\\Response',
            'session'    =>  'System\\Session',
            'cookie'     =>  'System\\Cookie',
            'load'       =>  'System\\Loader',
            'html'       =>  'System\\Html',
            'db'         =>  'System\\Database',
            'view'       =>  'System\\ViewFactory',
            ];
    }


    /*
    * Get Shared Value Dynamically
     *
     * it's for magic variable $this->file everytime use $this->file called function __get then
     * call function get() to get the file form container array .
     *
     * @param String $key
     * $return mixed
    */
    public function __get($key)
    {
        return $this->get($key);
    }



}