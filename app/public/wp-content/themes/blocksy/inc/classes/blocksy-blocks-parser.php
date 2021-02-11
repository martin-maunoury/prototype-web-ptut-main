<?php

class Blocksy_WP_Block_Parser extends WP_Block_Parser {
	function parse($document) {
		$result = parent::parse($document);

		$current_index = 0;

		foreach ($result as $index => $first_level_block) {
			$result[$index]['firstLevelBlock'] = true;

			if (! empty(trim($first_level_block['innerHTML']))) {
				$result[$index]['firstLevelBlockIndex'] = $current_index++;
			}
		}

		return $result;
	}
}
