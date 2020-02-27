<?php

class Model_Referedevent extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'event_id',
		'refered_by',
		'refered_to',
		'message',
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
	protected static $_table_name = 'referedevents';


    public static function event_invite_exchanged($event_id, $referred_by, $referred_to) {
        $event_invite = DB::query("SELECT * FROM referedevents WHERE (event_id = $event_id AND refered_by = $referred_by AND refered_to = $referred_to)")
            ->as_object('Model_Referedevent')->execute();
        return count($event_invite) > 0 ? true : false;
    }

    public static function get_invited_events($referred_to) {
        $event_ids = array();
        $event_invites = DB::query("SELECT * FROM referedevents WHERE (refered_to = $referred_to AND message = '" . Model_Friendship::STATUS_ACCEPTED ."')")
            ->as_object('Model_Referedevent')->execute();

        foreach ($event_invites as $event_invite) { //exclude expired events
            if(Model_Event::is_active_event($event_invite->event_id)) {
                array_push($event_ids, $event_invite->event_id);
            }
        }

        return count($event_ids) > 0 ? Model_Event::query()
            ->where("id", "IN", $event_ids)
            ->get() : array();
    }
}
