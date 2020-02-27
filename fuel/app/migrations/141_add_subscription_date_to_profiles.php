<?php

namespace Fuel\Migrations;

class Add_subscription_date_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'subscription_date' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'subscription_expiry_date' => array('constraint' => 11, 'type' => 'int', 'null' => true),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'subscription_date',
            'subscription_expiry_date'

		));
	}
}