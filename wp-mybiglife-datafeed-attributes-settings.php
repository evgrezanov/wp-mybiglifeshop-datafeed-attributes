<?php

// info:
// https://gist.github.com/EricBusch/fbe9f7164ec0d4a85d70d0f430581e9a
// https://datafeedrapi.helpscoutdocs.com/article/221-import-attribute-for-a-product

/**
 * Plugin Name: WP Mybiglife Shop Datafeed Atributts
 * Description: Some settings for woocommerce attributes and datafeed
 * Plugin URI: https://github.com/evgrezanov/wp-mybiglifeshop-datafeed-attributes
 * Version: 0.1.0
 * Author: Evgeniy Rezanov
 * Author URI: https://github.com/evgrezanov/wp-mybiglifeshop-datafeed-attributes
 * 
 */
class wpMyBigLifeDataFeedAttributesSettings{

    public static function init (){
        require plugin_dir_path( __FILE__ ) . 'attributes/brand.php';
        require plugin_dir_path( __FILE__ ) . 'attributes/size.php';
        //require plugin_dir_path( __FILE__ ) . 'attributes/color.php';
        //add_filter( 'dfrpswc_filter_attribute_value', array(__CLASS__, 'mycode_import_gender_attribute'), 20, 6 );
        //add_filter( 'dfrpswc_filter_attribute_value', array(__CLASS__, 'mycode_import_age_group_attribute'), 20, 6 );
        //add_filter( 'dfrpswc_filter_attribute_value', array(__CLASS__, 'mycode_import_country_attribute'), 20, 6 );
        //add_filter( 'dfrpswc_filter_attribute_value', array(__CLASS__, 'mycode_import_material_attribute'), 20, 6 );
    }


    /**
     * Add the product's Gender as an attribute.
     *
     * The attribute "Gender" with a slug of "gender" must already exist here: WordPress Admin Area > Products > Attributes
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
    public static function mycode_import_gender_attribute( $value, $attribute, $post, $product, $set, $action ) {

        $ai = new Dfrpswc_Attribute_Importer( 'gender', $value, $attribute, $product );

        $ai->add_field( [ 'gender', 'attribute6.name.description' ], 'gender' );

        $ai->add_term( "Womens", [ "female", "womens", "woman", "women" ] );
        $ai->add_term( "Mens", [ "male", "mens", "man", "men" ] );

        return $ai->result();
    }

    

    /**
     * Add the product's Age Group as an attribute.
     *
     * The attribute "Age Group" with a slug of "age-group" must already exist here: WordPress Admin Area > Products > Attributes
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
    public static function mycode_import_age_group_attribute( $value, $attribute, $post, $product, $set, $action ) {

        $ai = new Dfrpswc_Attribute_Importer( 'age-group', $value, $attribute, $product );

        $ai->add_field( [ 'gender.name.description.category' ], '', 'All Ages' );

        $ai->add_term(
            "Girls",
            [ "girl" ],
            [ "womens", "woman", "women", "adult", "ladies" ]
        );

        $ai->add_term(
            "Boys",
            [ "boy" ],
            [ "mens", "man", "men", "adult" ]
        );

        $ai->add_term(
            "Womens",
            [ "female", "womens", "woman", "women" ],
            [ "girl", "girls", "child", "children", "kids", "kid" ]
        );

        $ai->add_term(
            "Mens",
            [ "male", "mens", "man", "men" ],
            [ "boy", "boys", "child", "children", "kids", "kid" ]
        );

        $ai->add_term(
            "Adult",
            [ "male", "mens", "man", "men", "female", "womens", "woman", "women" ],
            [ "boy", "boys", "girl", "girls", "child", "children", "kids", "kid" ]
        );

        $ai->add_term(
            "Children",
            [ "boy", "boys", "girl", "girls", "child", "children", "kids", "kid" ],
            [ "male", "mens", "man", "men", "womens", "woman", "women" ]
        );

        return $ai->result();
    }

    /**
     * Add the product's Country Name as an attribute.
     *
     * The attribute "Country" with a slug of "country" must already exist here: WordPress Admin Area > Products > Attributes
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
    public static function mycode_import_country_attribute( $value, $attribute, $post, $product, $set, $action ) {

        $ai = new Dfrpswc_Attribute_Importer( 'country', $value, $attribute, $product );

        $ai->add_field( [ "source", "merchant" ], "country", 'United States' );

        $ai->add_term( "Australia", [ "AU" ] );
        $ai->add_term( "Austria", [ "AT" ] );
        $ai->add_term( "Belgium", [ "BE" ] );
        $ai->add_term( "Brazil", [ "BR" ] );
        $ai->add_term( "Brazil", [ "BR" ] );
        $ai->add_term( "Canada", [ "CA" ] );
        $ai->add_term( "Denmark", [ "DK" ] );
        $ai->add_term( "Finland", [ "FI" ] );
        $ai->add_term( "France", [ "FR" ] );
        $ai->add_term( "Germany", [ "DE" ] );
        $ai->add_term( "Ireland", [ "IE" ] );
        $ai->add_term( "Italy", [ "IT" ] );
        $ai->add_term( "India", [ "IN" ] );
        $ai->add_term( "Netherlands", [ "NL" ] );
        $ai->add_term( "New Zealand", [ "NZ" ] );
        $ai->add_term( "Norway", [ "NO" ] );
        $ai->add_term( "Poland", [ "PL" ] );
        $ai->add_term( "Portugal", [ "PT" ] );
        $ai->add_term( "Spain", [ "ES" ] );
        $ai->add_term( "Sweden", [ "SE" ] );
        $ai->add_term( "Switzerland", [ "CH" ] );
        $ai->add_term( "United Kingdom", [ "UK", "GB" ] );
        $ai->add_term( "United States", [ "US", "USA" ] );

        return $ai->result();
    }

    /**
     * Add the product's Country Name as an attribute.
     *
     * The attribute "Country" with a slug of "country" must already exist here: WordPress Admin Area > Products > Attributes
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
    public static function mycode_import_material_attribute( $value, $attribute, $post, $product, $set, $action ) {

        $ai = new Dfrpswc_Attribute_Importer( 'material', $value, $attribute, $product );

        $ai->add_field( [ "description.name.material" ], "material" );

        $ai->add_term( "Bamboo" );
        $ai->add_term( "Denim", [ "jean", "jeans" ] );
        $ai->add_term( "Flannel" );
        $ai->add_term( "Fur" );
        $ai->add_term( "Glass" );
        $ai->add_term( "Leather", [ "cowhide" ] );
        $ai->add_term( "Metal", [ "copper", "steel", "iron", "aluminum" ] );
        $ai->add_term( "Nylon" );
        $ai->add_term( "Plastic" );
        $ai->add_term( "Polyester" );
        $ai->add_term( "Rayon" );
        $ai->add_term( "Spandex" );
        $ai->add_term( "Wood" );

        return $ai->result();
    }

}

 wpMyBigLifeDataFeedAttributesSettings::init();

 ?>