<?php

namespace Fuel\Migrations;

class Create_us_postal_codes
{
	public function up()
	{
		\DBUtil::create_table('us_postal_codes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'zip_code' => array('constraint' => 255, 'type' => 'varchar'),
			'city' => array('constraint' => 255, 'type' => 'varchar'),
			'state' => array('constraint' => 255, 'type' => 'varchar'),
			'state_abbreviation' => array('constraint' => 50, 'type' => 'varchar'),
			'county' => array('constraint' => 255, 'type' => 'varchar'),
			'latitude' => array('constraint' => 255, 'type' => 'varchar'),
			'longitude' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('us_postal_codes');
	}
}