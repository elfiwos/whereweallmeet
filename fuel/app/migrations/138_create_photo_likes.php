<?php

namespace Fuel\Migrations;

class Create_photo_likes
{
	public function up()
	{
		\DBUtil::create_table('photo_likes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'file_name' => array('type' => 'text'),
			'liker' => array('constraint' => 11, 'type' => 'int'),
			'date' => array('type' => 'datetime'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('photo_likes');
	}
}