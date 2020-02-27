<?php

namespace Fuel\Migrations;

class Add_type_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'type' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'type'

		));
	}
}