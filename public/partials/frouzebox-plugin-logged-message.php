<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://maturocha.com.ar
 * @since      1.0.0
 *
 * @package    Frouzebox_Plugin
 * @subpackage Frouzebox_Plugin/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="logged-message">
  <h2><?php _e('Vous êtes déjà connecté','frouzebox-forms');?></h2>
  <a itemprop="url" href="/my-account/" target="_self" data-hover-background-color="#ff9f1f" data-hover-border-color="#fff" data-hover-color="#fff" class="qbutton  small right default" style="color: rgb(255, 255, 255); border-color: rgb(255, 159, 31); font-style: normal; font-weight: 400; font-family: Rubik; text-transform: none; font-size: 15px; letter-spacing: 0.2px; background-color: rgb(255, 159, 31);" rel="noopener noreferrer">
  <?php _e('ALLER ESPACE CLIENT','frouzebox-forms');?> <i class="qode_icon_font_awesome fa fa-sign-in qode_button_icon_element" style="color: #fff;"></i>
  </a>
  
</div>
