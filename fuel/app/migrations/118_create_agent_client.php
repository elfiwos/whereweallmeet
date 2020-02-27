<?php

namespace Fuel\Migrations;

class Create_agent_client
{
	public function up()
	{
		\DBUtil::create_table('agent_client', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'client_id' => array('constraint' => 11, 'type' => 'int'),
			'agent_id' => array('constraint' => 11, 'type' => 'int'),
			'occupation' => array('type' => 'text'),
			'looking_for' => array('type' => 'text'),
			'life_so_far' => array('type' => 'text'),
			'like_to_do' => array('type' => 'text'),
			'favorite_things' => array('type' => 'text'),
			'favorite_places' => array('type' => 'text'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('agent_client');
	}
}