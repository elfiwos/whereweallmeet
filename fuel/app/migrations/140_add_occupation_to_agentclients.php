<?php

namespace Fuel\Migrations;

class Add_occupation_to_agentclients
{
	public function up()
	{
		\DBUtil::add_fields('agentclients', array(
			'occupation' =>  array('type' => 'text', 'null' => true),
            'looking_for' => array('type' => 'text', 'null' => true),
            'life_so_far' => array('type' => 'text', 'null' => true),
            'like_to_do' => array('type' => 'text', 'null' => true),
            'favorite_things' => array('type' => 'text', 'null' => true),
            'favorite_places' => array('type' => 'text', 'null' => true),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('agentclients', array(
			'occupation',
            'looking_for',
            'life_so_far',
            'like_to_do',
            'favorite_things',
            'favorite_places',
		));
	}
}