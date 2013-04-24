<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Philip Sturgeon
 * @created 04/06/2009
 */
class REST
{

    private $_ci;
                // CodeIgniter instance
    private $rest_server;
    private $supported_formats = array(
        'xml' => 'application/xml',
        'json' => 'application/json',
        'serialize' => 'application/vnd.php.serialized',
        'php' => 'text/plain',
        'csv' => 'text/csv'
    );
    private $auto_detect_formats = array(
        'application/xml' => 'xml',
        'text/xml' => 'xml',
        'application/json' => 'json',
        'text/json' => 'json',
        'text/csv' => 'csv',
        'application/csv' => 'csv',
        'application/vnd.php.serialized' => 'serialize'
    );

    private $format;
    private $mime_type;
    private $_property;
    private $response_string;

    function __construct($config = array())
    {
        $this->_ci = & get_instance();
        log_message('debug', 'REST Class Initialized');

        $this->_ci->load->library('curl');

        // If a URL was passed to the library
        if (!empty($config))
        {
            $this->_property = $config['property'];
            unset($config['property']);
            $this->initialize($config);
        }

        if($this->_property == ''){$this->_property = 'yosemite';}
    }

    public function initialize($config)
    {
        $this->rest_server = @$config['server'];

        if (substr($this->rest_server, -1, 1) != '/')
        {
            $this->rest_server .= '/';
        }

        $this->http_auth = isset($config['http_auth']) ? $config['http_auth'] : '';
        $this->http_user = isset($config['http_user']) ? $config['http_user'] : '';
        $this->http_pass = isset($config['http_pass']) ? $config['http_pass'] : '';
    }

    public function get($uri, $params = array(), $format = NULL)
    {
        if ($params)
        {
            $uri .= '?' . (is_array($params) ? http_build_query($params) : $params);
        }

        return $this->_call('get', $uri, NULL, $format);
    }

    public function post($uri, $params = array(), $format = NULL)
    {
        return $this->_call('post', $uri, $params, $format);
    }

    public function put($uri, $params = array(), $format = NULL)
    {
        return $this->_call('put', $uri, $params, $format);
    }

    public function delete($uri, $params = array(), $format = NULL)
    {
        return $this->_call('delete', $uri, $params, $format);
    }

    public function api_key($key, $name = 'X-API-KEY')
    {
        $this->_ci->curl->http_header($name, $key);
    }

    public function language($lang)
    {
        if (is_array($lang))
        {
            $lang = implode(', ', $lang);
        }

        $this->_ci->curl->http_header('Accept-Language', $lang);
    }

    private function _call($method, $uri, $params = array(), $format = NULL)
    {
        if ($format !== NULL)
        {
            $this->format($format);
        }

        $this->_set_headers();

        $this->api_key($this->_ci->config->item('api_key', $this->_property), 'INNSIGHT-API-KEY');
        $this->api_key($this->_ci->config->item('api_request_type', $this->_property), 'API-REQUEST-TYPE');
        // Initialize cURL session
        $this->_ci->curl->create($this->rest_server . $uri);

        // If authentication is enabled use it
        if ($this->http_auth != '' && $this->http_user != '')
        {
            $this->_ci->curl->http_login($this->http_user, $this->http_pass, $this->http_auth);
        }

        // We still want the response even if there is an error code over 400
        $this->_ci->curl->option('failonerror', FALSE);

        $param = explode('&', $params);
        if (!empty($param))
        {
            $p = array();
            foreach ($param as $value)
            {
                list($key, $val) = explode('=', $value);
                $val = (string) $val;
                $p[] = $key . '=' . $this->_encode($val);
            }
            $p[] = 'app_id=' . $this->_encode($this->_ci->config->item('innsight_app_id', $this->_property));
            $p[] = 'api_key=' . $this->_encode($this->_ci->config->item('api_key', $this->_property));

            if ($this->_ci->session->userdata('access_token') != '')
            {
                $p[] = 'access_token=' . $this->_encode($this->_ci->session->userdata('access_token'));
                $p[] = 'auth_user=' . $this->_encode($this->_ci->config->item('auth_user',$this->_property));
                $p[] = 'auth_pass=' . $this->_encode($this->_ci->config->item('auth_pass',$this->_property));
            }
            $params = implode('&', $p);
        }

        // Call the correct method with parameters
        $this->_ci->curl->{$method}($params);

        // Execute and return the response from the REST server
        $response = $this->_ci->curl->execute();
        $response = (array) $this->_format_response($response);

        if ($response['status'] == 'success')
        {
            if ($response['result'] == 'array')
            {
                $response['responseData'] = unserialize($this->_decode($response['responseData']));

                if (is_array($response['responseData']))
                {
                    if (array_key_exists('access_token', $response['responseData']))
                    {
                        $this->_ci->session->set_userdata('access_token', $response['responseData']['access_token']);
                    }
                }
            }
            elseif ($response['result'] == 'string')
            {
                $response['responseData'] = $this->_decode($response['responseData']);
            }
        }
        // Format and return
        return $response;
    }

    // If a type is passed in that is not supported, use it as a mime type
    public function format($format)
    {
        if (array_key_exists($format, $this->supported_formats))
        {
            $this->format = $format;
            $this->mime_type = $this->supported_formats[$format];
        }
        else
        {
            $this->mime_type = $format;
        }

        return $this;
    }

    public function debug()
    {
        $request = $this->_ci->curl->debug_request();

        echo "=============================================<br/>\n";
        echo "<h2>REST Test</h2>\n";
        echo "=============================================<br/>\n";
        echo "<h3>Request</h3>\n";
        echo $request['url'] . "<br/>\n";
        echo "=============================================<br/>\n";
        echo "<h3>Response</h3>\n";

        if ($this->response_string)
        {
            echo "<code>" . nl2br(htmlentities($this->response_string)) . "</code><br/>\n\n";
        }
        else
        {
            echo "No response<br/>\n\n";
        }

        echo "=============================================<br/>\n";

        if ($this->_ci->curl->error_string)
        {
            echo "<h3>Errors</h3>";
            echo "<strong>Code:</strong> " . $this->_ci->curl->error_code . "<br/>\n";
            echo "<strong>Message:</strong> " . $this->_ci->curl->error_string . "<br/>\n";
            echo "=============================================<br/>\n";
        }

        echo "<h3>Call details</h3>";
        echo "<pre>";
        print_r($this->_ci->curl->info);
        echo "</pre>";
    }

    private function _set_headers()
    {
        $this->_ci->curl->http_header('Accept: ' . $this->mime_type);
    }

    private function _format_response($response)
    {
        $this->response_string = & $response;

        // It is a supported format, so just run its formatting method
        if (array_key_exists($this->format, $this->supported_formats))
        {
            return $this->{"_" . $this->format}($response);
        }

        // Find out what format the data was returned in
        $returned_mime = @$this->_ci->curl->info['content_type'];

        // If they sent through more than just mime, stip it off
        if (strpos($returned_mime, ';'))
        {
            list($returned_mime) = explode(';', $returned_mime);
        }

        $returned_mime = trim($returned_mime);

        if (array_key_exists($returned_mime, $this->auto_detect_formats))
        {
            return $this->{'_' . $this->auto_detect_formats[$returned_mime]}($response);
        }

        return $response;
    }

    // Format XML for output
    private function _xml($string)
    {
        return (array) simplexml_load_string($string);
    }

    // Format HTML for output
    // This function is DODGY! Not perfect CSV support but works with my REST_Controller
    private function _csv($string)
    {
        $data = array();

        // Splits
        $rows = explode("\n", trim($string));
        $headings = explode(',', array_shift($rows));
        foreach ($rows as $row)
        {
            // The substr removes " from start and end
            $data_fields = explode('","', trim(substr($row, 1, -1)));

            if (count($data_fields) == count($headings))
            {
                $data[] = array_combine($headings, $data_fields);
            }
        }

        return $data;
    }

    // Encode as JSON
    private function _json($string)
    {
        return json_decode(trim($string));
    }

    // Encode as Serialized array
    private function _serialize($string)
    {
        return unserialize(trim($string));
    }

    // Encode raw PHP
    private function _php($string)
    {
        $string = trim($string);
        $populated = array();
        eval("\$populated = \"$string\";");
        return $populated;
    }

    private function _encode($string)
    {
        $key = $this->_ci->config->item('api_private_key', $this->_property);
        $key = sha1($key);
        $strLen = strlen($string);
        $keyLen = strlen($key);
        $j = 0;
        $hash = '';

        for ($i = 0; $i < $strLen; $i++)
        {
            $ordStr = ord(substr($string, $i, 1));
            if ($j == $keyLen)
            {
                $j = 0;
            }
            $ordKey = ord(substr($key, $j, 1));
            $j++;
            $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
        }
        return $hash;
    }

    private function _decode($string)
    {
        $key = $this->_ci->config->item('api_private_key', $this->_property);
        $key = sha1($key);
        $strLen = strlen($string);
        $keyLen = strlen($key);
        $j = 0;
        $hash = '';

        for ($i = 0; $i < $strLen; $i+=2)
        {
            $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
            if ($j == $keyLen)
            {
                $j = 0;
            }
            $ordKey = ord(substr($key, $j, 1));
            $j++;
            $hash .= chr($ordStr - $ordKey);
        }
        return $hash;
    }

}

// END REST Class

/* End of file REST.php */
/* Location: ./application/libraries/REST.php */