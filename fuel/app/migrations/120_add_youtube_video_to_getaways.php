<?php

namespace Fuel\Migrations;

class Add_youtube_video_to_getaways
{
	public function up()
	{
		\DBUtil::add_fields('getaways', array(
			'youtube_video' => array('constraint' => 250, 'type' => 'varchar', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('getaways', array(
			'youtube_video'

		));
	}
}