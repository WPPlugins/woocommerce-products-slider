<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	//global $wp_query;
	$meta_query = array();
	$tax_query = array();

	if($wcps_hide_out_of_stock=='yes'){

        $tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field' => 'name',
            'terms' => 'outofstock',
            'operator' => 'NOT IN',
        );
		
		}
    elseif($wcps_hide_out_of_stock=='no'){

        $tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field' => 'name',
            'terms' => 'outofstock',
            'operator' => 'IN',
        );
    }







	if($wcps_product_featured=='yes'){

		
		$tax_query[] = array(
						'taxonomy' => 'product_visibility',
						'field' => 'name',
						'terms' => 'featured',
						'operator' => 'IN',
						);	

		}
    elseif($wcps_product_featured=='no'){

        $tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field' => 'name',
            'terms' => 'featured',
            'operator' => 'NOT IN',
        );

    }

		
	if($wcps_product_on_sale=='yes'){
		
		$meta_query[] =  array(
							array(
							'key' => '_visibility',
							'value' => array('catalog', 'visible'),
							'compare' => 'IN'
							),
							array(
							'key' => '_sale_price',
							'value' => 0,
							'compare' => '>',
							'type' => 'NUMERIC'
							)
							);
		
		}	
		
		
	$query_args = array (
		'post_type'			=> 'product',
		'post_status'		=> 'publish',
		'orderby'			=> $wcps_query_orderby,
		'order'				=> $wcps_query_order,
		'posts_per_page'	=> $wcps_total_items,
		'meta_query'		=> $meta_query,
		'tax_query'		=> $tax_query,		
		

		);
		
	$query_args = apply_filters('wcps_filter_query_args', $query_args);
		
	//echo '<pre>'.var_export($query_args, true).'</pre>';	
	
	$wp_query = new WP_Query($query_args);
