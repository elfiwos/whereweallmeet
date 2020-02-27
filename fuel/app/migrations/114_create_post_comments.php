<?php

namespace Fuel\Migrations;

class Create_post_comments
{
	public function up()
	{
		\DBUtil::create_table('post_comments', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'poster' => array('constraint' => 11, 'type' => 'int'),
			'post_id' => array('constraint' => 11, 'type' => 'int'),
			'comment' => array('constraint' => 300, 'type' => 'varchar'),
			'comment_date' => array('type' => 'datetime'),
			'commented_by' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('post_comments');
	}
}