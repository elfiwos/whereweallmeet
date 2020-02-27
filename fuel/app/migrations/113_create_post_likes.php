<?php

namespace Fuel\Migrations;

class Create_post_likes
{
	public function up()
	{
		\DBUtil::create_table('post_likes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'liked_by_id' => array('constraint' => 11, 'type' => 'int'),
			'post_id' => array('constraint' => 11, 'type' => 'int'),
			'like_date' => array('type' => 'datetime'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('post_likes');
	}
}