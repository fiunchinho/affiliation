<?php

namespace Affiliation;

class Mapping
{
	/**
	 * Mapping between product names and urls to redirect to.
	 * @var array
	 */
	private $mapping;

	/**
	 * In case that detected country is not recognized, we'll use this one.
	 * @var string
	 */
	private $default_country;

	/**
	 * In case that the product is not in our catalogue, redirect to this one.
	 * @var string
	 */
	private $default_product;

	/**
	 * 
	 * @param array  $mapping         Mapping between product names and urls to redirect to
	 * @param string $default_country Default country
	 * @param string $default_product Default product
	 */
	public function __construct( array $mapping, $default_country, $default_product )
	{
		$this->mapping 			= $mapping;
		$this->default_country 	= $default_country;
		$this->default_product 	= $default_product;

		if ( !array_key_exists( $default_country, $mapping ) || !array_key_exists( $default_product, $this->mapping[$default_country] ) )
		{
			throw new \InvalidArgumentException( 'Product was not found. Did you choose a default country/product that actually exists?' );
		}
	}

	/**
	 * Search through our product list and return the link associated with that product, for the specified country
	 * 
	 * @param  string $product      Product to search for
	 * @param  string $country_code Detected country
	 * @return string               The link to the affiliation page
	 */
	public function findProductLink( $product, $country_code )
	{
		$country_code 	= $this->useDefaultCountryIfNoMappingForThisCountry( $country_code );
		$country_code 	= $this->useParentMappingIfInheritsFromOther( $country_code );
		$product 		= $this->useDefaultProductIfNoMappingForThisProduct( $product, $country_code );

		return $this->mapping[$country_code][$product];
	}

	private function useDefaultCountryIfNoMappingForThisCountry( $country_code )
	{
		if ( !array_key_exists( $country_code, $this->mapping ) )
		{
			return $this->default_country;
		}

		return $country_code;
	}

	private function useDefaultProductIfNoMappingForThisProduct( $product, $country_code )
	{
		if ( !array_key_exists( $product, $this->mapping[$country_code] ) )
		{
			return $this->default_product;
		}

		return $product;
	}

	private function useParentMappingIfInheritsFromOther( $country_code )
	{
		if ( !is_array( $this->mapping[$country_code] ) )
		{
			return $this->mapping[$country_code];
		}

		return $country_code;
	}
}