<?php

class Model_Referfriends extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'refer_from',
		'refer_to',
		'refered_id',
		'status',
		
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
	protected static $_table_name = 'refer_friends';

   const INVITATION_PENDING = 0;
    const INVITATION_ACCEPTED = 1;
    const INVITATION_REJECTED = 2;


    public static function has_pending_invitations($profile_id)
    {
        $refer_friends = Model_Referfriends::query()
        ->where(
                array(
                    'refer_to' => $profile_id,
                    'status' => self::INVITATION_PENDING
                )
        )
        ->get();

        if(count($refer_friends) > 0){
            return true;
        }

        return false;
    }

    public static function get_one_pending_invitation($profile_id)
    {
        $dating_agent_invitations = Model_Referfriends::query()
            ->where(
                array(
                    'refer_to' => $profile_id,
                    'status' => self::INVITATION_PENDING
                )
            )
            //->order_by('created_at')
            ->get_one();

        if(count($dating_agent_invitations) === 1){
            return $dating_agent_invitations;
        }

        return false;
    }

    public static  function get_agent_referrals($client_id, $agent_id) {
        $refered_member_ids = array();

        $referred_friends = DB::query("SELECT * FROM refer_friends WHERE (refer_to = $client_id AND refer_from = " . $agent_id . ")")
            ->as_object('Model_Referfriends')->execute();
        foreach ($referred_friends as $referred_friend) {
            array_push($refered_member_ids, $referred_friend->refered_id);
        }

        return count($refered_member_ids) > 0 ? Model_Profile::query()
            ->where("id", "IN", $refered_member_ids)
            ->get() : array();
    }
    public static  function get_agent_all_referrals($agent_id) {
        $refered_member_ids = array();

        $referred_friends = DB::query("SELECT * FROM refer_friends WHERE (refer_from = " . $agent_id . ")")
            ->as_object('Model_Referfriends')->execute();
        foreach ($referred_friends as $referred_friend) {
            array_push($refered_member_ids, $referred_friend->refered_id);
        }

        return count($refered_member_ids) > 0 ? Model_Profile::query()
            ->where("id", "IN", $refered_member_ids)
            ->get() : array();
    }
    public static function count_agent_referrals($agent_id){
        $referred_friends = DB::query("SELECT * FROM refer_friends WHERE (refer_from = " . $agent_id . ")")
            ->as_object('Model_Referfriends')->execute();

        return count($referred_friends);
    }

}
