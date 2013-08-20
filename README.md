Maribol Geocode Service v 0.1
===============

Use the following code to get address informations from Google Geocoding API

<pre>
    $geo = new GeocodeService($_GET['address']);
    print_r($geo->info);
</pre>