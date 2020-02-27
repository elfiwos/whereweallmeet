<?php

namespace Fuel\Migrations;

class Create_invitedmembers
{
	public function up()
	{
		\DBUtil::create_table('invitedmembers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'member_id' => array('constraint' => 11, 'type' => 'int'),
			'inviter_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('invitedmembers');
	}
}