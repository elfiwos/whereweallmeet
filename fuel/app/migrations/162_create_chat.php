<?php

namespace Fuel\Migrations;

class Create_chat
{
	public function up()
	{
		\DBUtil::create_table('chat', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'chat_room_id' => array('constraint' => 300, 'type' => 'varchar'),
			'chat_sender' => array('constraint' => 150, 'type' => 'varchar'),
			'chat_reciever' => array('constraint' => 150, 'type' => 'varchar'),
			'chat_line' => array('type' => 'text'),
			'created_at' => array('type' => 'time'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('chat');
	}
}