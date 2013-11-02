<?php

namespace spec\Affiliation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LocalizerSpec extends ObjectBehavior
{
	function let( $mapping, $geocoder )
	{
		$mapping->beADoubleOf( 'Affiliation\Mapping' );
    	$geocoder->beADoubleOf( 'Geocoder\Geocoder' );
    	$this->beConstructedWith( $mapping, $geocoder );
	}

    function it_is_initializable( $mapping, $geocoder )
    {
        $this->shouldHaveType('Affiliation\Localizer');
    }

    function it_asks_to_mapping_about_the_link( $mapping, $geocoder, $geocode )
    {
    	$user_ip 		= '8.8.8.8';
    	$country_code 	= 'ES';
    	$product 		= 'product';
    	$geocode->beADoubleOf( 'Geocoder\Result\Geocoded' );
    	$geocoder->geocode( $user_ip )->willReturn( $geocode );
    	$mapping->findProductLink( $product, Argument::any() )->shouldBeCalled();
    	
        $this->localizeLink( $product, $user_ip );
    }
}
