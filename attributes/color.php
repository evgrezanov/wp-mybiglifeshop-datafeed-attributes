<?php

class wpMyBigLifeDataFeedColorAttribute{

    public static function init (){
        //add_filter( 'dfrpswc_filter_attribute_value', array(__CLASS__, 'mycode_normalize_brand_name'), 20, 6 );
        add_filter( 'dfrpswc_filter_attribute_value', array(__CLASS__, 'mycode_import_color_attribute'), 20, 6 );

    }

}
wpMyBigLifeDataFeedColorAttribute::init();