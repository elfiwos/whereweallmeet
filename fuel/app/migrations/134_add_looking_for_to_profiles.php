<?php

namespace Fuel\Migrations;

class Add_looking_for_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'looking_for' => array('type' => 'text'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'looking_for'

		));
	}
}