<?php

/**
 * Fired when the plugin is uninstalled.
 */

/* 
 * exit uninstall if not called by WP
 */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

delete_option('uni_lms_db_version');

