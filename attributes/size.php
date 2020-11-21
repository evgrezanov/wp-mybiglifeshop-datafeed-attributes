<?php

class wpMyBigLifeDataFeedSizeAttribute{

    public static function init (){
        add_filter( 'dfrpswc_filter_attribute_value', array(__CLASS__, 'mycode_import_size_attribute'), 20, 6 );
        add_filter( 'dfrpswc_filter_attribute_value', array(__CLASS__, 'mycode_add_size_attribute'), 30, 6 );
    }

    /**
     * Add the product's Size as an attribute.
     *
     * The attribute "Size" with a slug of "size" must already exist here: WordPress Admin Area > Products > Attributes
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
    public static function mycode_add_size_attribute( $value, $attribute, $post, $product, $set, $action ) {

        $ai = new Dfrpswc_Attribute_Importer( 'size', $value, $attribute, $product );

        $ai->add_field( [ 'size' ] );

        // If a field contains a comma "," split the field into multiple values.
        $ai->field_delimiter = ',';

        $ai->add_term( "S", [ "small", "Small", "s", "sm" ], [ "x-small" ], [ "xs", "x-small" ] );
        $ai->add_term( "M", [ "medium", "Medium", "m", "md", "med" ] );
        $ai->add_term( "L", [ "large", "Large", "l", "lg" ] );
        $ai->add_term( "XL",[ "Extra Large", "x-large", "xl" ] );
        $ai->add_term( "X", [ "Extra", "x" ] );
        $ai->add_term( "XXL", [ "Extra Extra Large", "xx-large", "xxx-large" ] );

        return $ai->result();
    }



    /**
     * Add the product's size as a size attribute for this product.
     *
     * The attribute "Size" with a slug of "size" must already exist here:
     * WordPress Admin Area > Products > Attributes.
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
    public static function mycode_import_size_attribute( $value, $attribute, $post, $product, $set, $action ) {

        if ( $attribute != 'pa_size' ) {
            return $value;
        }

        if ( isset( $product['size'] ) ) {
            return self::mycode_get_size( $product['size'] );
        }

        if ( isset( $product['attribute3'] ) ) {
            return self::mycode_get_size( $product['attribute3'] );
        }

        // add other fields if need
        // todo

        return $value;
    }

    /**
     * A function to normalize size attribute names.
     *
     * This returns a normalized value of a term based on a supplied
     * array of mappings of a key (desired word) mapped to an array of
     * keywords (undesired words).
     *
     * @param string $field The value to normalize.
     * @param string $default Optional. What to return if the $field value doesn't have a "normalized" value. Default: ''
     *
     * @return string Normalized attribute value.
     */
    public static function mycode_get_size( $field, $default = '' ) {

        $map = array();

        // ++++++++++ Begin Editing Here ++++++++++

        // Small, Medium, Large Sizes
        $map["XXXS"]   = array( "xxx small" );
        $map["XXS"]    = array( "xx small" );
        $map["XS"]     = array( "x small" );
        $map["Small"]  = array( "sm", "s" );
        $map["Medium"] = array( "md", "med", "m" );
        $map["Large"]  = array( "lg", "l" );
        $map["XL"]     = array( "extra large", "x large" );
        $map["XXL"]    = array( "xx large" );
        $map["XXXL"]   = array( "xxx large" );

        // European Shoe Sizes
        $map["34"]   = array( "34", "UK 2" );
        $map["34.5"] = array( "34.5", "UK 2" );
        $map["35"]   = array( "35", "UK 2.5" );
        $map["35.5"] = array( "35.5", "UK 3" );
        $map["36"]   = array( "36", "UK 3.5" );
        $map["36.5"] = array( "36.5", "UK 3.5" );
        $map["37"]   = array( "37", "UK 4" );
        $map["37.5"] = array( "37.5", "UK 4.5" );
        $map["38"]   = array( "38", "UK 5" );
        $map["38.5"] = array( "38.5", "UK 5.5" );
        $map["39"]   = array( "39", "UK 6" );
        $map["39.5"] = array( "39.5", "UK 6.5" );
        $map["40"]   = array( "40", "UK 7" );
        $map["40.5"] = array( "40.5", "UK 7" );
        $map["41"]   = array( "41", "UK 7.5" );
        $map["41.5"] = array( "41.5", "UK 7.5" );
        $map["42"]   = array( "42", "UK 8" );
        $map["42.5"] = array( "42.5", "UK 8.5" );
        $map["43"]   = array( "43", "UK 9" );
        $map["43.5"] = array( "43.5", "UK 9" );
        $map["44"]   = array( "44", "UK 9.5" );
        $map["44.5"] = array( "44.5", "UK 10" );
        $map["45"]   = array( "45", "UK 10.5" );
        $map["45.5"] = array( "45.5", "UK 10.5" );
        $map["46"]   = array( "46", "UK 11" );
        $map["46.5"] = array( "46.5", "UK 11.5" );
        $map["47"]   = array( "47", "UK 12" );


        // ++++++++++ Stop Editing Here ++++++++++

        $terms = array();

        foreach ( $map as $key => $keywords ) {

            if ( preg_match( '/\b' . preg_quote( $key, '/' ) . '\b/iu', $field ) ) {
                $terms[] = $key;
            }

            foreach ( $keywords as $keyword ) {
                if ( preg_match( '/\b' . preg_quote( $keyword, '/' ) . '\b/iu', $field ) ) {
                    $terms[] = $key;
                }
            }
        }

        if ( ! empty( $terms ) ) {
            return implode( WC_DELIMITER, array_unique( $terms ) );
        }

        return $default;
    }

}
wpMyBigLifeDataFeedSizeAttribute::init();