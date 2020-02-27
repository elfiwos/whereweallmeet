<?php

namespace Fuel\Migrations;

class Create_getaways
{
	public function up()
	{
		\DBUtil::create_table('getaways', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'slug' => array('constraint' => 255, 'type' => 'varchar'),
			'long_description' => array('type' => 'text'),
			'venue' => array('constraint' => 255, 'type' => 'varchar'),
			'start_date' => array('type' => 'date'),
			'start_time' => array('type' => 'time'),
			'photo' => array('constraint' => 255, 'type' => 'varchar'),
			'state' => array('constraint' => 255, 'type' => 'varchar'),
			'city' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),
			'end_time' => array('type' => 'time'),
			'is_featured' => array('constraint' => 11, 'type' => 'int'),
			'organizers_details' => array('constraint' => 255, 'type' => 'varchar'),
			'time_zone' => array('constraint' => 255, 'type' => 'varchar'),
			'zip' => array('constraint' => 255, 'type' => 'varchar'),
			'get_away_end_date' => array('constraint' => 255, 'type' => 'varchar'),
			'start_pm_am' => array('constraint' => 255, 'type' => 'varchar'),
			'end_pm_am' => array('constraint' => 255, 'type' => 'varchar'),
			'url' => array('type' => 'text'),
			'short_description' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('getaways');
	}
}