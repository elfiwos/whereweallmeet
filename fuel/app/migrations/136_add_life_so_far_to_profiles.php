<?php

namespace Fuel\Migrations;

class Add_life_so_far_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'life_so_far' => array('type' => 'text'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'life_so_far'

		));
	}
}