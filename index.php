<?php
/*
This file is free software: you can redistribute it and/or modify
the code under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version. 

However, the license header, copyright and author credits 
must not be modified in any form and always be displayed.

This class is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

@author geoPlugin (gp_support@geoplugin.com)
@copyright Copyright geoPlugin (gp_support@geoplugin.com)

This file is an example PHP file of the geoplugin class
to geolocate IP addresses using the free PHP Webservices of
http://www.geoplugin.com/

*/

require_once('geoplugin.class.php');

$geoplugin = new geoPlugin();

/* 
Notes:

The default base currency is USD (see http://www.geoplugin.com/webservices:currency ).
You can change this before the call to geoPlugin::locate with eg:
$geoplugin->currency = 'EUR';

The default IP to lookup is $_SERVER['REMOTE_ADDR']
You can lookup a specific IP address, by entering the IP in the call to geoPlugin::locate
eg
$geoplugin->locate('209.85.171.100');

The default language is English 'en'
supported languages:
de (German)
en (English - default)
es (Spanish)
fr (French)
ja (Japanese)
pt-BR (Portugese, Brazil)
ru (Russian)
zh-CN (Chinese, Zn)

To change the language to e.g. Japanese, use:
$geoplugin->lang = 'ja';

*/

//locate the IP
$geoplugin->locate();

/*
echo "Geolocation results for {$geoplugin->ip}: <br />\n".
	"City: {$geoplugin->city} <br />\n".
	"Region: {$geoplugin->region} <br />\n".
	"Region Code: {$geoplugin->regionCode} <br />\n".
	"Region Name: {$geoplugin->regionName} <br />\n".
	"Country Name: {$geoplugin->countryName} <br />\n".
	"Country Code: {$geoplugin->countryCode} <br />\n".
	"Latitude: {$geoplugin->latitude} <br />\n".
	"Longitude: {$geoplugin->longitude} <br />\n";
*/

header("Location: https://api.github.com/repos/copasi/COPASI/releases/latest");

$fh = fopen("version-check.log", 'a');
if ($fh === false) return;

//Waiting until file will be locked for writing
$canWrite = false;

while (!$canWrite) {
  $canWrite = flock($fh, LOCK_EX);

  // If lock not obtained sleep for 2 - 5 micro seconds, to avoid colision
  if(!$canWrite) {
    $nanoSeconds = rand(2000, 5000); // 0 1 u = 100 miliseconds
    time_nanosleep(0 , $nanoSeconds);
  }
}
  
$iso_date = gmdate("Y-m-d\TH:i:s\Z");
  
fwrite($fh, "$iso_date,$geoplugin->ip,$geoplugin->city,$geoplugin->region,$geoplugin->regionCode,$geoplugin->regionName,$geoplugin->countryName,$geoplugin->countryCode,$geoplugin->latitude,$geoplugin->longitude\n");

fclose($fh);
  
?>