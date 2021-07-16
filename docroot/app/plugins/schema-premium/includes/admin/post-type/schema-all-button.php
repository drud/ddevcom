<?php
/**
 * All Schema Types Button link
 *
 * @since 1.2
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_print_footer_scripts', 'schema_premium_add_all_schema_types_button_link' );
/**
 * Add a link to Schema post type management page in edit screen
 *
 * @since 1.2
 * @return void 
 */
function schema_premium_add_all_schema_types_button_link(){
     
     $screen = get_current_screen();
     
     if ( ! isset($screen->id) )
          return;

     if ( $screen->id == 'schema' && $screen->parent_base == 'edit' ) {
          
          $anchor_text = __('All Schema Types', 'schema-premium');
          ?>
               <script>
               jQuery('.wrap .page-title-action').after('<a href="edit.php?post_type=schema" class="add-new-h2"><?php echo $anchor_text; ?></a>');
               </script>
          <?php
     }
}
