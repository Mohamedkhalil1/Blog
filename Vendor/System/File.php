<?php

namespace System;
class File
{
    /*
    * Directory Separator
     *
     * @Const string
    */
    const DS = DIRECTORY_SEPARATOR;   // DIRECTORY_SEPARATOR = '/'


    /*
     * Root Path
     *
     * @var String
     * */
    private $root;    // Path

    /*
     * Constructor
     *
     * $param string $root
    */
    public function __construct($root)
    {
        $this->root =$root;  // __DIR__
    }

    /*
      * Determine wether the given file path exist
      *
      * @param string $file
      * @return bool
   */

    public function exists($file)
    {
        return file_exists($file);
    }

    /*
   *  Require the given file path
   *
   * @param string $file
   * @return Void
    */

    public function require($file)
    {
        require $file;        // return the path
    }

    /*
    * Generate Full path to the given path in vendor folder
     *
     * @param string $path
     * @return string
    */
    public function toVendor($path)
    {
        return $this->to('Vendor/'.$path);
    }

    /*
 * Generate Full path to the given path
  *
  * @param string $path
  * @return string
 */
  public function to($path)
  {
    return $this->root . static::DS . str_replace(['/' , '\\'] , static::DS,$path);
  }
}