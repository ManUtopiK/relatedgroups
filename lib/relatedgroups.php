<?php
/**
 * Related groups helper functions
 *
 * @package ElggRelatedGroups
 */


/**
 * Gives the list of the group related groups
 *
 * @param ElggGroup $group
 * @return array
 */
function get_relatedgroups($group, $options = array()){
	if($group instanceof ElggGroup){
		
		$options['relationship'] = 'related';
		$options['relationship_guid'] = $group->guid;
		
		return elgg_get_entities_from_relationship(array($options));
		
	} else {
		return false;
	}
}

function list_relatedgroups($group, $options = array()){
	
	if($group instanceof ElggGroup){
		
		$defaults = array(
			'full_view' => false,
			'pagination' => true,
		);
		$options = array_merge($defaults, $options);
		
		$options['relationship'] = 'related';
		$options['relationship_guid'] = $group->guid;
	
		return elgg_list_entities_from_relationship($options);
		
	} else {
		return "";
	}
}
