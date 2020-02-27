<?php

namespace Fuel\Migrations;

class Add_education_id_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'education_id' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'education_id'

		));
	}
}