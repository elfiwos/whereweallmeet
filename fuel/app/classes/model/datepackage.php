<?php

class Model_Datepackage extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'title',
		'event_date',
		'time_from',
		'time_to',
		'event_venue',
		'short_description',
		'long_description',
        'url',
		'is_featured',
		'picture',
		'state',
		'city',
		'price',
		'zip_code',
		'event_end_date',
		'start_pm_am',
		'end_pm_am',
        'youtube_video',
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
	protected static $_table_name = 'datepackages';
	
    public static $thumbnails = array(
        "event_list" => array("width" => 302, "height" => 225),
        "event_detail" => array("width" => 466, "height" => 344),
        "event_featured" => array("width" => 301, "height" => 231),
        "event_rsvp" => array("width" => 157, "height" => 126),
        "event_cover" => array("width" => 746, "height" => 360),
    );

    public static function get_active_packages_by_region($state, $city)
    {
        $result = \Fuel\Core\DB::query("SELECT id, title, long_description, short_description, url, youtube_video, event_venue,
        DATE_FORMAT(event_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(time_from, '%h:%i %p') AS start_time, picture,
        state, city, TIME_FORMAT(time_to, '%h:%i %p') AS end_time, DATE_FORMAT(event_end_date,'%W, %M %d, %Y ') AS end_date, price, created_at, updated_at
        FROM datepackages WHERE state='".$state."' AND
        city LIKE '%".$city."%'
        AND event_end_date >= CURDATE()
        ORDER BY start_date ASC, start_time DESC")->execute();

        if(count($result) > 0)
            return $result;

        return false;
    }
    public static function get_past_packages_by_region($state, $city)
    {
        $result = \Fuel\Core\DB::query("SELECT id, title, long_description, short_description, url, youtube_video, event_venue,
        DATE_FORMAT(event_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(time_from, '%h:%i %p') AS start_time, picture,
        state, city, TIME_FORMAT(time_to, '%h:%i %p') AS end_time, price, created_at, updated_at
        FROM datepackages WHERE state='".$state."' AND
        city LIKE '%".$city."%'
        AND event_end_date < CURDATE()
        ORDER BY start_date DESC, start_time DESC")->execute();

        if(count($result) > 0)
            return $result;

        return false;
    }

}
