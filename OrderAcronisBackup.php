<?php

// Composer
require __DIR__ . '/vendor/autoload.php';

use Httpful\Request;
use Httpful\Http;
use Httpful\Mime;

$IkoulaEndpoint="https://commande.ikoula.com/api";
$Username="";
$Password="";
$OrderRestMethod="/order"; # The rest method to call
$AcronisCategoryId="31"; # Got from /category api call 
$AcronisProductId="603"; # Got from /category/@category_id/product api call
$ProductFileName="product_acronis.json";

# First get the configuration of the product we want to order
$JsonProductToOrder= file_get_contents($ProductFileName);

# Create a POST request template
$IkoulaApiPostTemplate = Request::init()
 ->method(Http::POST)
 ->withStrictSSL()
 ->expectsJSON()
 ->sendsType(Mime::JSON);

# Print contents of the json file
print $JsonProductToOrder."\n";

# Launch the ordering of the product. May be automatically provisionned or not depending on payment status and gateways
Request::ini($IkoulaApiPostTemplate);

$IkoulaOrderApiResponse = Request::post($IkoulaEndpoint.$OrderRestMethod."/".$AcronisProductId)
 ->authenticateWith($Username, $Password)
 ->send();

if($IkoulaOrderApiResponse) {

 echo json_encode($IkoulaOrderApiResponse->body, JSON_PRETTY_PRINT);

} else {

 var_export($IkoulaOrderApiResponse);

}

?>
