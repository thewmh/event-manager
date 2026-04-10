<?php
/**
 * Uninstall Event Submission Layer
 *
 * This file is called when the plugin is uninstalled.
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Read page IDs before deleting options
$page_ids = [
    get_option('esl_add_event_page_id'),
    get_option('esl_events_dashboard_page_id'),
];

// Delete the created pages
foreach ($page_ids as $page_id) {
    if ($page_id) {
        wp_delete_post($page_id, true);
    }
}

// Delete options
delete_option('esl_add_event_page_id');
delete_option('esl_events_dashboard_page_id');
delete_option('esl_options');
delete_option('esl_sc_notice_dismissed');

// Remove the custom role
remove_role('event_submitter');

// Clean up transients
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_esl_form_message_%'");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_esl_form_message_%'");
