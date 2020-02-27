<?php

namespace Fuel\Migrations;

class Create_politics
{
	public function up()
	{
		\DBUtil::create_table('politics', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('type' => 'text'),
			'created_at' => array('type' => 'time'),
			'updated_at' => array('type' => 'time'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('politics');
	}
}