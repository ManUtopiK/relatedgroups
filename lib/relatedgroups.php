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
function get_relatedgroups($group, $offset=0, $limit=0){
	if($group instanceof ElggGroup){
		$relgroups = elgg_get_entities_from_relationship(
			array('relationship'=>'related', 'relationship_guid'=>$group->guid, 'offset'=>$offset, 'limit'=>$limit));
		return $relgroups;
	} else {
		return false;
	}
}

function elgg_view_relatedgroups_list($group){
	$relgroups = get_relatedgroups($group);
	if(!$relgroups) {
		return false;
	}
	$html = '<ul class="elgg-list">';
	foreach($relgroups as $relgroup){
		$html .= '<li class="elgg-item">';
		$html .= elgg_view('relatedgroups/display', array(
			'relgroup' => $relgroup,
			'group' => $group
		));
		$html .= '</li>';
	}
	$html .= '</ul>';
	return $html;
}
