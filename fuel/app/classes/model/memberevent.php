<?php

class Model_Memberevent extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'member_id',
		'event_id',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);
	protected static $_table_name = 'memberevents';

    public static function is_event_booked($event_id, $member_id) {
        $member_events = DB::query("SELECT * FROM memberevents WHERE event_id = $event_id AND member_id= $member_id")
            ->as_object('Model_Memberevent')->execute();
        return count($member_events) > 0 ? true : false;
    }
}
