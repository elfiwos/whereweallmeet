<?php

namespace Fuel\Migrations;

class Add_youtube_video_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'youtube_video' => array('constraint' => 250, 'type' => 'varchar', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'youtube_video'

		));
	}
}