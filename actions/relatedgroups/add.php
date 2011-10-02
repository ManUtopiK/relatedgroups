<?php
	function relatedgroups_is_group_url($url, &$matches = array()){
		$url = parse_url($url);
		$pattern = "/groups\/profile\/(?P<group_guid>\d+)\//";
		return preg_match($pattern, $url['path'], $matches) != 0;
	}

	function relatedgroups_get_group_from_url($group_url){
		$matches = array();
		relatedgroups_is_group_url($group_url, $matches);
		$group_guid = $matches['group_guid'];
		$group = get_entity($group_guid);
		if($group->getURL() == $group_url){
			return $group;
		} else {
			return false;
		}
	}
	$group_guid = get_input('group');
	$othergroup_guid = get_input('othergroup');
	$othergroup_url = get_input('othergroup_url'); // maybe it isn't used
	$group = get_entity($group_guid);
	$othergroup = get_entity($othergroup_guid);

	if(!$othergroup && relatedgroups_is_group_url($othergroup_url)){
		$othergroup = relatedgroups_get_group_from_url($othergroup_url);
		$othergroup_guid = $othergroup->guid;
	}

	if ($group instanceof ElggGroup && $group->canEdit() && $othergroup instanceof ElggGroup) {
		if (!check_entity_relationship($group_guid, 'related', $othergroup_guid) && $group_guid != $othergroup_guid) {
			add_entity_relationship($group_guid, 'related', $othergroup_guid);
		}
	}
	else{
		register_error(elgg_echo('relatedgroups:add:error'));
	}
	forward(REFERER);
?>
