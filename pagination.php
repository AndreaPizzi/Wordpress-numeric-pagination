<?php if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * 
 * Wordpress numeric pagination with:
 * - prev / next link can be visible or not
 * - prev / next symbol
 * - text before pagination ( immediatly on left )
 * - can show number as decimal ( 01 ) or not ( 1 )
 * - Choose how many element for page to display, you can add different conditions
 *  **/

function my_post_count_queries( $query ) { // The "Items for page" parmaeters 
    if ($query->is_main_query()){
        if(is_author()){ // You can add different conditions
        $query->set('posts_per_page', 3);
        }
    }
  }
add_action( 'pre_get_posts', 'my_post_count_queries' );

 /** Customize Paginations options from Theme Options **/

    $prev_symbol = "<";
    $next_symbol = ">";
    $next_prev_active = false;
    $pag_algn  = "text-center";
    $prev_text = "pagina";
    $decimal_num_active = true;


/** Create Paginations nvigation **/

function choosepizzi_numeric_posts_nav() {

    global $prev_symbol;
    global $next_symbol;
    global $pag_algn;
    global $next_prev_active;
    global $prev_text;
    global $decimal_num_active;

	if( is_singular() )
		return;

    global $wp_query;

	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo "<div class='row row__pagination'><p>". __($prev_text, 'wp_collio') ."</p><ul class='pagination'> \n";

    /**	Previous Post Link */
    if( $next_prev_active === true){
        if ( get_previous_posts_link() )
            printf( '<li class="page-item">%s</li>' . "", get_previous_posts_link($prev_symbol, '') );
    }

	/**	Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active page-item"' : '';
		printf( '<li%s><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '01' );

		if ( ! in_array( 2, $links ) )
			echo '<li class="page-item">…</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active page-item"' : '';
        if( $decimal_num_active === true){
            $decimal_num_link = sprintf("%02s", $link) ;
        }else{
            $decimal_num_link = $link;
        }
		printf( '<li%s><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $decimal_num_link );
	}

	/**	Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active page-item"' : '';
        if( $decimal_num_active === true){
            $decimal_num = sprintf("%02s", $max) ;
        }else{
            $decimal_num = $max;
        }
        printf( '<li%s><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $decimal_num );
	}

    /**	Next Post Link */
    if( $next_prev_active === true){
        if ( get_next_posts_link() )
            printf( '<li class="page-link next_btn">%s</li>' . "\n", get_next_posts_link($next_symbol,'') );
    }

	echo '</ul></div>' . "\n";

}
