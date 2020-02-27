<?php

namespace Fuel\Migrations;

class Add_like_doing_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'like_doing' => array('type' => 'text'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'like_doing'

		));
	}
}