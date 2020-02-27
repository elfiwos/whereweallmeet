<?php

namespace Fuel\Migrations;

class Add_youtube_video_to_datepackages
{
	public function up()
	{
		\DBUtil::add_fields('datepackages', array(
			'youtube_video' => array('constraint' => 250, 'type' => 'varchar', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('datepackages', array(
			'youtube_video'

		));
	}
}