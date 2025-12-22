<?php
/**
 * SVG icons related functions
 *
 */

/**
 * Gets the SVG code for a given icon.
 */
function alone_addons_get_icon_svg( $icon, $size = 24 ) {
	return AloneAddons_SVG_Icons::get_svg( 'ui', $icon, $size );
}

/**
 * Gets the SVG code for a given social icon.
 */
function alone_addons_get_social_icon_svg( $icon, $size = 24 ) {
	return AloneAddons_SVG_Icons::get_svg( 'social', $icon, $size );
}
