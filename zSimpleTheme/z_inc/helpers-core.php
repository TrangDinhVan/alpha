<?php
function z_pagination($query){
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}
	echo '<div class="z-pagination d-flex pt-4">';
	$big = 999999999; // need an unlikely integer
	$current = max( 1, $paged );
	echo paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => $current,
	    'total' => $query->max_num_pages,
	    'prev_text'  => '<i class="vnp-arrow-left"></i>',
	    'next_text'  => '<i class="vnp-arrow-right"></i>',
	) );
	echo '</div>';
}

function zing_wp_is_mobile() {
    static $is_mobile;

    if ( isset($is_mobile) )
        return $is_mobile;

    if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
        $is_mobile = false;
    } elseif (
        strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false ) {
            $is_mobile = true;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') == false) {
            $is_mobile = true;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
        $is_mobile = false;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}

if ( ! function_exists( 'z_render_view' ) ):
	function z_render_view( $file_path, $view_variables = array(), $return = false ) {
		if ( ! is_file( $file_path ) ) {
			return '';
		}
		extract( $view_variables, EXTR_REFS );
		unset( $view_variables );
		if ( $return ) {
			ob_start();
			require $file_path;
			return ob_get_clean();
		} else {
			require $file_path;
		}
		return '';
	}
endif; ?>