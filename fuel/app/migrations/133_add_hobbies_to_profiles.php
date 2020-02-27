<?php

namespace Fuel\Migrations;

class Add_hobbies_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'hobbies' => array('type' => 'text'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'hobbies'

		));
	}
}