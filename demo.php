<form action="">
    <input type="text" name="address" value="Caraiman 1, Cluj Napoca, Romania"> 
    <input type="submit" value="Get info"> 
</form>

<?php
include('GeocodeService.class.php');

if (isset($_GET['address'])) {
    $geo = new GeocodeService($_GET['address']);
    echo '<pre>';
    print_r($geo->info);
    echo '</pre>';
}
?>