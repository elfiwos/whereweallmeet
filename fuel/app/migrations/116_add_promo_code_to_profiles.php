<?php

namespace Fuel\Migrations;

class Add_promo_code_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'promo_code' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'promo_code'

		));
	}
}