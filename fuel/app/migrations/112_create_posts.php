<?php

namespace Fuel\Migrations;

class Create_posts
{
	public function up()
	{
		\DBUtil::create_table('posts', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'posted_by' => array('constraint' => 11, 'type' => 'int'),
			'post_content' => array('constraint' => 300, 'type' => 'varchar'),
			'visibility' => array('type' => 'text'),
			'post_date' => array('type' => 'datetime'),
			'status' => array('type' => 'text'),
			'posted_for' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('posts');
	}
}