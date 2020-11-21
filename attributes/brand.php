<?php

class wpMyBigLifeDataFeedBrandAttribute{

    public static function init (){
        add_filter( 'dfrpswc_filter_attribute_value', array(__CLASS__, 'mycode_normalize_brand_name'), 20, 6 );
    }

    /**
     * Normalize the product's Brand's name when importing as an attribute.
     *
     * The attribute "Brand" with a slug of "brand" must already exist here: WordPress Admin Area > Products > Attributes
     *
     * @param array|string $value The current value of the $attribute for this $post.
     * @param string $attribute The slug of the attribute. Examples: pa_color or pa_shoe-size
     * @param array $post An array of post data including ID, post_title, post_status, etc...
     * @param array $product An array of product data returned from the Datafeedr API.
     * @param array $set A post array for this Product Set with an array key of postmeta containing all post meta data.
     * @param string $action The action the Product Set is performing. Value are either "insert" or "update".
     *
     * @return array|string The updated attribute's value.
     */
    public static function mycode_normalize_brand_name( $value, $attribute, $post, $product, $set, $action ) {

        $ai = new Dfrpswc_Attribute_Importer( 'brand', $value, $attribute, $product );

        $ai->add_field( [ "brand" ], "brand" );

        $ai->add_term( "Adidas",  [ "Summit Sports Sites", "SummitSports" ]  );
        $ai->add_term( "AppOutdoors", [ "AppOutdoors.com" ] );
        $ai->add_term( "Black Diamond" );
        $ai->add_term( "C.A.M.P.", [ "camp" ] );
        $ai->add_term( "CampSaver", [ "CampSaver.com" ] );
        $ai->add_term( "ChinaVision" );
        $ai->add_term( "Mad Rock", [ "madrock" ] );
        $ai->add_term( "Marmot" );
        $ai->add_term( "Metolius" );
        $ai->add_term( "Outdoor Play", [ "outdoorplay" ] );
        $ai->add_term( "Petzl" );
        $ai->add_term( "REI" );
        $ai->add_term( "Summit Sports", [ "Summit Sports Sites", "SummitSports" ] );
        $ai->add_term( "The North Face", [ "north face" ] );

        $result = $ai->result();

        return $result;
    }
}
wpMyBigLifeDataFeedBrandAttribute::init();