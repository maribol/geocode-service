<?php

/**
 * Copyright (c) 2013 Samuel Todosiciuc.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of the
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package     Maribol Geocode Service v 0.1
 * @author      Samuel Todosiciuc <samuel.todosiciuc@gmail.com>
 * @copyright   2013 Samuel Todosiciuc.
 * @link        https://github.com/maribol/
 */
class GeocodeService
{

    public $info;
    public $server = 'maps.google.com';
    public $server_path = '/maps/api/geocode/json';

    function __construct($address, $language = 'en', $sensor = 'false')
    {
        $address = $this->encode($this->formatString($address));
        if (empty($address)) {
            die('Invalid address');
            return FALSE;
        }
        $params = '?address=' . $address . '&language=' . $language . '&sensor=' . $sensor;
        $this->info = $this->getJson($this->server, $this->server_path, $params);
    }

    function getJson($host, $path, $req = '', $port = 80)
    {
        $header = "GET $path$req HTTP/1.0\r\n";
        $header .= "Host: $host\r\n";
        $header .= "Content-Type: text/html\r\n";
        $header .= "User-Agent: GGeocoderParserLib(PHPlib-V1)\r\n";
        $header .= "Connection: Close\r\n";
        $header .= "\r\n";
        $response = '';
        if (false == ( $fs = @fsockopen($host, $port, $errno, $errstr, 10) )) {
            die('Could not open socket');
        }
        fwrite($fs, $header);
        while (!feof($fs)) {
            $response .= fgets($fs, 1500);
        }
        fclose($fs);
        $response = json_decode(substr($response, strpos($response, "\r\n\r\n") + 4));
        return $response->results[0];
    }

    function formatString($data)
    {
        $data = preg_replace("/[^a-zA-Z0-9 ,]/", "", $data);
        return $data;
    }

    function encode($data)
    {
        $data = urlencode(stripslashes($data));
        return $data;
    }

}

?>