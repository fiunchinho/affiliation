<?php

namespace spec\Affiliation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MappingSpec extends ObjectBehavior
{
	private function getMapping()
	{
		return array(
			'es' => array(
				'product1' => 'www.example.com/product1-es',
				'product2' => 'www.example.com/product2-es'
			),
			'fr' => array(
				'product1' => 'www.example.com/product1-fr',
				'product2' => 'www.example.com/product2-fr'
			),
			'us' => 'es'
		);
	}
    function it_finds_product1_from_french_mappings()
    {
    	$this->beConstructedWith( $this->getMapping(), 'es', 'product1' );
        $this->findProductLink( 'product1', 'fr' )->shouldReturn( 'www.example.com/product1-fr' );
    }

    function it_finds_product2_from_french_mappings()
    {
    	$this->beConstructedWith( $this->getMapping(), 'es', 'product1' );
        $this->findProductLink( 'product2', 'fr' )->shouldReturn( 'www.example.com/product2-fr' );
    }

    function it_finds_product2_from_spanish_mappings()
    {
    	$this->beConstructedWith( $this->getMapping(), 'es', 'product1' );
        $this->findProductLink( 'product2', 'es' )->shouldReturn( 'www.example.com/product2-es' );
    }

    function it_returns_default_product_when_does_not_find_product3_from_french_mappings()
    {
    	$this->beConstructedWith( $this->getMapping(), 'es', 'product1' );
        $this->findProductLink( 'product3', 'fr' )->shouldReturn( 'www.example.com/product1-fr' );
    }

    function it_returns_product_from_default_country_when_does_not_find_the_country_in_mappings()
    {
    	$non_existing_country = 'de';
    	$this->beConstructedWith( $this->getMapping(), 'es', 'product1' );
        $this->findProductLink( 'product2', $non_existing_country )->shouldReturn( 'www.example.com/product2-es' );
    }

    function it_returns_default_product_from_default_country_when_does_not_find_the_country_neither_the_product_in_mappings()
    {
    	$non_existing_country = 'de';
    	$non_existing_product = 'product3';
    	$this->beConstructedWith( $this->getMapping(), 'es', 'product1' );
        $this->findProductLink( $non_existing_product, $non_existing_country )->shouldReturn( 'www.example.com/product1-es' );
    }

    function it_uses_mapping_from_parent_country_when_no_products_defined_for_that_country()
    {
    	$country_inheriting_from_es = 'us';
    	$this->beConstructedWith( $this->getMapping(), 'fr', 'product1' );
        $this->findProductLink( 'product2', $country_inheriting_from_es )->shouldReturn( 'www.example.com/product2-es' );
    }
}
