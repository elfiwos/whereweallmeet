<?php

namespace Fuel\Migrations;

class Add_places_visited_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'places_visted' => array('type' => 'text'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'places_visted'

		));
	}
}