<?php

namespace Fuel\Migrations;

class Create_memberevents
{
	public function up()
	{
		\DBUtil::create_table('memberevents', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'member_id' => array('constraint' => 11, 'type' => 'int'),
			'event_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('memberevents');
	}
}