<?php

namespace Fuel\Migrations;

class Add_refered_id_to_refer_friends
{
	public function up()
	{
		\DBUtil::add_fields('refer_friends', array(
			'refered_id' => array('constraint' => 11,'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('refer_friends', array(
			'refered_id'

		));
	}
}