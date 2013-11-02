<?php
require_once __DIR__ . '/vendor/autoload.php';

define( 'MAPPING_FILE', 'mapping.yml' );
define( 'DEFAULT_COUNTRY', 'ES' );
define( 'DEFAULT_PRODUCT', 'choose_one_of_the_products' );
define( 'URL_PREFIX', '/products/' );

// Instantiate Geocoder to geolocalize the user
$geocoder = new \Geocoder\Geocoder();
$geocoder->registerProvider( new \Geocoder\Provider\FreeGeoIpProvider( new \Geocoder\HttpAdapter\CurlHttpAdapter() ) );

// Load product/link mappings and create the localizer
$mapping 			= Symfony\Component\Yaml\Yaml::parse( MAPPING_FILE );
$affiliate_localizer= new Affiliation\Localizer( new Affiliation\Mapping( $mapping, DEFAULT_COUNTRY, DEFAULT_PRODUCT ), $geocoder );

// Get product url and transform it
$request 			= Symfony\Component\HttpFoundation\Request::createFromGlobals();
$product 			= ltrim( $request->getPathInfo(), URL_PREFIX );
$affiliate_link		= $affiliate_localizer->localizeLink( $product, $request->getClientIp() );

// Redirect to affiliate link
$response = new Symfony\Component\HttpFoundation\RedirectResponse( $affiliate_link );
$response->send();