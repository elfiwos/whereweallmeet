<?php

namespace Fuel\Migrations;

class Create_refereddateideas
{
	public function up()
	{
		\DBUtil::create_table('refereddateideas', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'refered_by' => array('constraint' => 11, 'type' => 'int'),
			'refered_to' => array('constraint' => 11, 'type' => 'int'),
			'message' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('refereddateideas');
	}
}