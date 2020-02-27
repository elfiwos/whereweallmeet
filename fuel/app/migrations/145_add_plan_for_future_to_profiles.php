<?php

namespace Fuel\Migrations;

class Add_plan_for_future_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'plan_for_future' => array('type' => 'text'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'plan_for_future'

		));
	}
}