<?php

class Weather_model extends Model
{

  /**
    * Constructor of the class
    *
    * Creates the object for this class
    *
    * @access	public
    * @param
    * @return	void
    */

    function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @param $lat
     * @param $long
     * @return array or 0
     * function to retrieve basic weather conditions
     */
    function get_weather_basic($lat='', $long='')
    {
        //if latitude and longitude isnt passed return 0
        if ($lat == '' || $long == '')
            return 0;

        $url = "http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query=" . $lat . ',' . $long;
        $weather = $this->curl_get_file_contents($url);

        //if curl wasnt successful in retrieving data return 0
        if ($weather == FALSE)
            return 0;
        $xml = new SimpleXMLElement($weather);
        $count = 0;
        $weather_forecast = array();

        foreach ($xml->simpleforecast->forecastday as $forecast)
        {
            $weather_forecast[$count]['day'] = $forecast->date->day . '';
            $weather_forecast[$count]['monthname'] = $forecast->date->monthname . '';
            $weather_forecast[$count]['month'] = $forecast->date->month . '';
            $weather_forecast[$count]['year'] = $forecast->date->year . '';
            $weather_forecast[$count]['weekday'] = $forecast->date->weekday . '';
            $weather_forecast[$count]['high'] = $forecast->high->fahrenheit . "°F/" . $forecast->high->celsius . "°C";
            $weather_forecast[$count]['low'] = $forecast->low->fahrenheit . "°F/" . $forecast->low->celsius . "°C";
            $weather_forecast[$count]['conditions'] = $forecast->conditions . '';
            $weather_forecast[$count]['icon'] = $forecast->icon . ".png";
            $count++;
        }

        return $weather_forecast;
    }

  /**
    * Gets the weather information
    *
    * Displays the response of calling given weather api
    *
    * @access	public
    * @return	void
    */

    function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents)
            return $contents;
        else
            return FALSE;
    }

}