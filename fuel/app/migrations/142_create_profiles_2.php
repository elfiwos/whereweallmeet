<?php

namespace Fuel\Migrations;

class Create_profiles_2
{
	public function up()
	{
		\DBUtil::create_table('profiles_2', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'career' => array('type' => 'text'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('profiles_2');
	}
}