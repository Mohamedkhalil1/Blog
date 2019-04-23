<?php



/*
 * Request Class
 *
 * Preprequirites
 *
 * _SERVER
 *
 * Request :: prepareURL Prepare URL and set it
 * Request :: get Get value from _GET
 * Request :: post Get Value from _POST
 * Request :: Server Get value from Server
 * Request :: Method get Request Method     //
 * Request :: BaseURL get domain path // http://sitename.com/blog
 * Request :: url Get Request url // relative only
 *
 * */
namespace System\Http;

class Request
{
    /*
     * URL
     *
     * @var string
     * */
    private $url;
    /*
     * Base URL
     *
     * @var string
     * */
    private $baseUrl;
    /*
     * Prepare  url
     *
     * @return void
     * */
    public function prepareUrl()
    {
        $script = dirname($this->server('SCRIPT_NAME'));
        $requestUri = $this->server('REQUEST_URI');
        if (strpos($requestUri, '?') !== false) {
            list($requestUri, $queryString) = explode('?', $requestUri);
        }
        //pre($_SERVER);
        $this->url = preg_replace('#^' . $script . '#', '', $requestUri);

        $this->baseUrl = $this->server('REQUEST_SCHEME'). '://' . $this->server('HTTP_HOST') . $script.'/';
    }

    /*
     * get value from _SERVER by given key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     * */
    public function server($key, $default = null)
    {
        return array_get($_SERVER, $key, $default);
    }

    /*
     * Get Only Relative url (clean url)
     *
     * @return string
     * */

    /*
     * Get Value from _GET by the given key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     * */
    public function get($key,$default)
    {
        return array_get($_GET,$key,$default);
    }

    /*
 * Get Value from _POST by the given key
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 * */
    public function post($key,$default)
    {
        return array_get($_POST,$key,$default);
    }


    /*
     * Get Current Request Method
     *
     * @return string
     * */
    public function method()
    {
        return $this->server('REQUEST_METHOD');
    }

    /*
     * Get full url of the script
     *
     * @return string
     * */
    public function baseUrl()
    {
        return $this->baseUrl;
    }

    public function url()
    {
        return $this->url;
    }
}