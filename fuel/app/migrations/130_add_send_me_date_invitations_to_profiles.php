<?php

namespace Fuel\Migrations;

class Add_send_me_date_invitations_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'send_me_date_invitations' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'send_me_date_invitations'

		));
	}
}