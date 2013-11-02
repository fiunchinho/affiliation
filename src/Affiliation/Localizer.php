<?php
namespace Affiliation;

class Localizer
{
	/**
	 * Object that holds the information required to translate products into links
	 * @var Mapping
	 */
	private $mapping;

	/**
	 * @param Mapping          	$mapping  Current mapping between products and affiliation pages
	 * @param Geocoder\Geocoder $geocoder Library to geolocalize users by their IP address
	 */
	public function __construct( Mapping $mapping, \Geocoder\Geocoder $geocoder )
	{
		$this->mapping 	= $mapping;
		$this->geocoder = $geocoder;
	}

	/**
	 * Given a product and IP, return the affiliation link to redirect the user
	 * 
	 * @param  string $product The product to seearch
	 * @param  string $ip      User's IP
	 * @return string          The link to the affiliation page
	 */
	public function localizeLink( $product, $ip )
	{
		$geocode = $this->geocoder->geocode( $ip );
		return $this->mapping->findProductLink( $product, $geocode->getCountryCode() );
	}
}