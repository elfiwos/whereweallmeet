<?php

namespace Fuel\Migrations;

class Add_seeking_politics_id
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'seeking_politics_id' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'seeking_politics_id'

		));
	}
}