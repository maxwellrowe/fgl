<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form id="searchForm" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <span class="search-icon" aria-hidden="true"></span>
    <input type="search" name="s" class="field" id="search-box"
        value="<?php echo get_search_query(); ?>"
        aria-label="<?php esc_attr_e( 'Search', 'foothill-gold-line' ); ?>"
        placeholder="<?php esc_attr_e( 'search', 'foothill-gold-line' ); ?>" />
</form>
