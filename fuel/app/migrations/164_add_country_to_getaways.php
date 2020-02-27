<?php

namespace Fuel\Migrations;

class Add_country_to_getaways
{
	public function up()
	{
		\DBUtil::add_fields('getaways', array(
			'country' => array('constraint' => 100, 'type' => 'varchar', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('countries', array(
			'country'

		));
	}
}