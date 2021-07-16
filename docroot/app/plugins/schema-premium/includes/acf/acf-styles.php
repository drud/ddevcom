<?php
/**
 * ACF - styles
 *
 * @package     Schema
 * @subpackage  Schema Post Meta ACF
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


add_action( 'admin_head', 'schema_wp_custom_acf_repeater_ovderride' );
/**
 * Repeater styles override for Schema post type screen
 *
 * @since 1.0.0
 *
 * @return void
 */
function schema_wp_custom_acf_repeater_ovderride() {

    if ( ! function_exists('get_current_screen') )
        return;

    $screen = get_current_screen();
    
    if ( ! isset($screen->post_type) )
        return;
    
    /*
     * Check if current screen is Schema post type
     * Don't output script if it's not
     */
    if ( $screen->post_type != 'schema' )
        return;
        
    echo '<style type="text/css">
            .acf-repeater > table,
            .acf-table > thead > tr > th,
            .acf-table > tbody > tr > td {
                border:0;
                padding:0;
            }
            .acf-repeater .acf-row-handle.order {
                cursor: default;
                position: absolute;
                left: -1999px;
            }
            .acf-table > tbody,
            .acf-repeater .acf-row-handle.remove {
                background: #fff !important;
            }
            .acf-fields.-border,
            .acf-field[data-width] + .acf-field[data-width] {
                border: 0;
            }
            .acf-fields > .acf-field {
                padding: 3px 6px;
            }
            .acf-repeater .acf-actions {
                text-align: right;
                margin-right: 22px;
            }
            .acf-table > thead > tr > th  {
                padding-bottom: 8px;
            }
            .acf-actions .button-primary {
                color: #555 !important;
                border-color: #ccc !important;
                background: #f7f7f7 !important;
                box-shadow: 0 1px 0 #ccc !important;
                text-shadow: none !important;
            }
            .select2-selection__clear {
                margin-right: 10px;
            }
         </style>';
}


add_action( 'acf/input/admin_footer', 'schema_wp_disable_acf_repeater_add_row' );
/**
 * Disable drag & drop repeater feature if current screen is Schema post type
 *
 * @since 1.0.0
 *
 * @return void
 */
function schema_wp_disable_acf_repeater_add_row() {
    
    if ( ! function_exists('get_current_screen') )
        return;

    $screen = get_current_screen();
    /*
     * Check if current screen is Schema post type
     * Don't output script if it's not
     */
    if ( $screen->post_type != 'schema' )
        return;
        
    ?>
    <script type="text/javascript">
        (function($) {
            if (typeof acf !== 'undefined') {
                /*$.extend( acf.fields.repeater, {
                    _mouseenter: function( e ){
                        if( $( this.$tbody.closest('.acf-field-repeater') ).hasClass('disable-sorting') ){
                            return;
                        }
                    }
                });*/
                $('.acf-row-handle a[data-event="add-row"]').remove();
                $('.acf-actions a').removeClass('button-primary')
            }
        })(jQuery);
    </script>
    <?php
}
