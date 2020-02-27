<?php

class Model_Post extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'posted_by',
		'post_content',
		'visibility',
		'post_date',
		'status',
		'posted_for',
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
	protected static $_table_name = 'posts';

public static function get_post_by($posted_by){

		try {
            $output = DB::query("SELECT * FROM posts WHERE posted_by='" . $posted_by . "'")->execute()->as_array();
            
            return $output;
        } catch (Exception $err) {
            return null;
        }

	}
	public function get_poster($post_id) {
		try {
            $output = DB::query("SELECT posted_by FROM posts WHERE id='" . intval($post_id) . "'")->execute()->as_array();
            
            return $output[0];
        } catch (Exception $err) {
            return null;
        }

	}
	public function get_post_date($post_id) {
		try {
            $output = DB::query("SELECT post_date FROM posts WHERE id='" . intval($post_id) . "'")->execute()->as_array();
            
            return $output[0];
        } catch (Exception $err) {
            return null;
        }

	 }
}
