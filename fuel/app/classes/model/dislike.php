<?php

class Model_Dislike extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'member_id',
		'disliked_member_id',
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
	protected static $_table_name = 'dislikes';

    public static function is_member_disliked($member_id, $disliked_member_id) {
        $dislike = DB::query("SELECT * FROM dislikes WHERE member_id = $member_id AND disliked_member_id = $disliked_member_id")
            ->as_object('Model_Dislike')->execute();
        return count($dislike) > 0 ? true : false;
    }

}
