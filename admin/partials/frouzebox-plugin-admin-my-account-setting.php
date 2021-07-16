<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wazabimkt.com/
 * @since      1.0.0
 *
 * @package    Wzb_Plugin
 * @subpackage Wzb_Plugin/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

    <div id="icon-themes" class="icon32"></div>
    <h2>Frouze Box Settings</h2>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
      <?php settings_fields( 'fb_myaccount_options_group' ); ?>
      <?php do_settings_sections( 'fb_myaccount_options' ); ?>
      <?php submit_button(); ?>
    </form>

</div><!-- /.wrap -->
