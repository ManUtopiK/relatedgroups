<?php
/**
 * Elgg related groups plugin
 *
 * @package ElggRelatedGroups
 */

elgg_register_event_handler('init', 'system', 'relatedgroups_init');

/**
 * Related groups plugin initialization functions.
 */
function relatedgroups_init() {
	// register a library of helper functions
	elgg_register_library('elgg:relatedgroups', elgg_get_plugins_path() . 'relatedgroups/lib/relatedgroups.php');

	// Register actions
	$actions_path = elgg_get_plugins_path() . 'relatedgroups/actions/relatedgroups';
	elgg_register_action("relatedgroups/add", $actions_path."/add.php");
	elgg_register_action("relatedgroups/remove", $actions_path."/remove.php");

	// Register page handler
	elgg_register_page_handler('relatedgroups', 'relatedgroups_page_handler');
	// Register pagesetup event handler	
	elgg_register_event_handler('pagesetup', 'system', 'relatedgroups_setup_sidebar_menus');

	// Extending views
	elgg_extend_view('groups/sidebar/members', 'groups/sidebar/relatedgroups');
	//TODO elgg_extend_view('groups/forum_latest', 'relatedgroups/frontpage');

	// Extending CSS
	elgg_extend_view('css/elements/components', 'groups/css/elements/components');

	// Add group tool
	add_group_tool_option('relatedgroups', elgg_echo('relatedgroups:in_frontpage'), false);
}

/**
 * Configure the groups sidebar menu. Triggered on page setup
 *
 */
function relatedgroups_setup_sidebar_menus() {

	// Get the page owner entity
	$page_owner = elgg_get_page_owner_entity();

	if (elgg_get_context() == 'groups') {
		if ($page_owner instanceof ElggGroup) {
			if (elgg_is_logged_in() && $page_owner->canEdit() || elgg_is_admin_logged_in()) {
				$url = elgg_get_site_url() . "relatedgroups/manage/{$page_owner->getGUID()}";
				elgg_register_menu_item('page', array(
					'name' => 'relatedgroups',
					'text' => elgg_echo('relatedgroups:manage'),
					'href' => $url,
				));
			}
		}
	}
}

/**
 * Dispatches related groups pages.
 * URLs take the form of
 *  
 *  Group view related groups:      relatedgroups/view/<group_guid>
 *  Group manage related groups:    relatedgroups/manage/<group_guid>
 *
 * @param array $page
 * @return NULL
 */
function relatedgroups_page_handler($page){
	$pages_path = elgg_get_plugins_path() . "relatedgroups/pages";
	switch($page[0]) {
		case 'manage':
			set_page_owner($page[1]);
			include($pages_path."/relatedgroups/manage.php");
			break;
		case 'view':
			set_page_owner($page[1]);
			include($pages_path."/relatedgroups/view.php");
			break;
	}
}
?>
