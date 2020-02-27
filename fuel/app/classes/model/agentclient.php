<?php

class Model_Agentclient extends \Orm\Model
{
    const STATUS_SENT = "sent";
    const STATUS_ACCEPTED = "accepted";
    const STATUS_REJECTED = "rejected";

    protected static $_properties = array(
		'id',
		'sender_id',
		'receiver_id',
		'status',
		'created_at',
		'updated_at',
        'occupation',
        'looking_for',
        'life_so_far',
        'like_to_do',
        'favorite_things',
        'favorite_places',
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
	protected static $_table_name = 'agentclients';

    public static function is_already_client($client_id, $dating_agent_id) {
        $agent_client = DB::query("SELECT * FROM agentclients WHERE sender_id = $client_id AND receiver_id = $dating_agent_id AND (status='" . Model_Agentclient::STATUS_SENT . "' OR status='" . Model_Agentclient::STATUS_ACCEPTED ."')")
            ->as_object('Model_Agentclient')->execute();
        return count($agent_client) > 0 ? true : false;
    }
    public static function is_already_booked($client_id) {
        $agent_client = DB::query("SELECT * FROM agentclients WHERE sender_id = $client_id AND (status='" . Model_Agentclient::STATUS_SENT . "' OR status='" . Model_Agentclient::STATUS_ACCEPTED ."')")
            ->as_object('Model_Agentclient')->execute();
        return count($agent_client) > 0 ? true : false;
    }

    public static function delete_booked_client($client_id) {
        $rows = DB::delete('agentclients')->where('sender_id', $client_id)
            ->execute();
        return $rows>0? true : false;
    }

    //count agent clients
    public static  function count_clients($profile_id) {
        $clients = Model_Agentclient::find('all', array(
            "where" => array(
                array("receiver_id", $profile_id),
                array('status', Model_Agentclient::STATUS_ACCEPTED),
            ),
        ));
        return count($clients);
    }

    //get agent profile for the specified client
    public static  function get_client_agent($client_id) {
        $client_agent = Model_Agentclient::find('first', array(
            "where" => array(
                array("sender_id", $client_id),
                array('status', Model_Agentclient::STATUS_ACCEPTED),
                "or" => array(
                    array("sender_id", $client_id),
                    array('status', Model_Agentclient::STATUS_SENT))
            ),
        ));

        return $client_agent;
    }

    public static  function get_clients($agent_profile_id) {
        $agent_ids = array();

        $clients = DB::query("SELECT * FROM agentclients WHERE receiver_id = $agent_profile_id AND (status='" . Model_Agentclient::STATUS_ACCEPTED ."')")
            ->as_object('Model_Agentclient')->execute();
        foreach ($clients as $client) {
            array_push($agent_ids, $client->sender_id);
        }

        return count($agent_ids) > 0 ? Model_Profile::query()
            ->where("id", "IN", $agent_ids)
            ->get() : array();
    }

    public static  function get_pending_clients($agent_profile_id) {
        $agent_ids = array();

        $clients = DB::query("SELECT * FROM agentclients WHERE receiver_id = $agent_profile_id AND (status='" . Model_Agentclient::STATUS_SENT ."')")
            ->as_object('Model_Agentclient')->execute();
        foreach ($clients as $client) {
            array_push($agent_ids, $client->sender_id);
        }

        return count($agent_ids) > 0 ? Model_Profile::query()
            ->where("id", "IN", $agent_ids)
            ->get() : array();
    }
}
