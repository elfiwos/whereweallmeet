<?php

namespace Fuel\Migrations;

class Add_career_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'career' => array('type' => 'text'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'career'

		));
	}
}