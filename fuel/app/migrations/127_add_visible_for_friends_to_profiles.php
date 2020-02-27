<?php

namespace Fuel\Migrations;

class Add_visible_for_friends_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'visible_for_friends' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'visible_for_friends'

		));
	}
}