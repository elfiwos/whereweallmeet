<?php

class Model_Getaway extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'title',
		'slug',
		'long_description',
		'venue',
		'start_date',
		'start_time',
		'photo',
        'country',
		'state',
		'city',
		'created_at',
		'updated_at',
		'end_time',
		'is_featured',
		'organizers_details',
		'time_zone',
		'zip',
		'get_away_end_date',
		'start_pm_am',
		'end_pm_am',
		'url',
		'short_description',
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
        'Orm\Observer_Slug',
	);
	protected static $_table_name = 'getaways';

    public static $thumbnails = array(
        "getaway_list" => array("width" => 302, "height" => 225),
        "getaway_detail" => array("width" => 466, "height" => 344),
        "getaway_featured" => array("width" => 301, "height" => 231),
        "getaway_rsvp" => array("width" => 157, "height" => 126),
        "getaway_cover" => array("width" => 746, "height" => 360),
    );

	public static function get_active_getaways_by_region($state, $city)
    {
        $result = \Fuel\Core\DB::query("SELECT id, title, slug, long_description, short_description, url, venue,
        DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
        country, state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at
        FROM getaways WHERE state='".$state."' AND
        city LIKE '%".$city."%'
        AND get_away_end_date >= CURDATE()
        ORDER BY start_date ASC, start_time DESC")->execute();
        if(count($result) > 0)
            return $result;

        return false;
    }

    public static function get_past_getaways_by_region($state, $city)
    {
        $result = \Fuel\Core\DB::query("SELECT id, title, slug, long_description, short_description, url, venue,
        DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
        country,state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at
        FROM getaways WHERE state='".$state."' AND
        city LIKE '%".$city."%'
        AND get_away_end_date < CURDATE()
        ORDER BY start_date DESC, start_time DESC")->execute();

        if(count($result) > 0)
            return $result;

        return false;
    }

    public static function get_slug($getaway_id)
    {
        $getaway = Model_Event::find($getaway_id);
        if($getaway){
            return  $getaway->slug;
        }

        return false;
    }


    public static function get_title($getaway_id)
    {
        $getaway = Model_Event::find($getaway_id);
        if($getaway){
            return $getaway->title;
        }

        return false;
    }

    public static function get_start_date($getaway_id)
    {
        $result = \Fuel\Core\DB::query("SELECT DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date
         FROM getaways WHERE id= $getaway_id")->execute();

        if(count($result) === 1)
            return $result[0];

        return false;
    }

    public static function find_by_slug($getaway_slug)
    {
        $result = \Fuel\Core\DB::query("SELECT id, title, slug, long_description, short_description, url, venue,
        DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
        country, state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, youtube_video, created_at, updated_at
        FROM getaways WHERE slug='". $getaway_slug."'")->execute();

        if(count($result) === 1)
            return $result[0];

        return false;
    }

    public static function get_featured_getaways()
    {
        $getaway = \Fuel\Core\DB::query("SELECT id, title, slug, long_description,short_description, url, venue,
        DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
        country, state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at FROM getaways
        WHERE is_featured = 1 ")->execute();
        if(count($getaway) > 0)
            return $getaway;

        return false;
    }

    public static function get_getaways_by_member_rsvp($user_id)
    {
        $rsvpied_getaways = \Fuel\Core\DB::query("SELECT * FROM rsvps WHERE member_id = $user_id")->execute();

        $count = count($rsvpied_getaways);
        $counter = 0;
        $where = ' WHERE ';

        foreach($rsvpied_getaways as $getaway){
            $where .= 'id = '.$getaway['event_id'];
            if($count !== ($counter + 1)){
                $where .= ' OR ';
            }
            ++$counter;
        }

        if(' WHERE ' !== $where){
            $result = \Fuel\Core\DB::query("SELECT id, title, slug, long_description, short_description, url,venue,
            DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
            country, state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at
            FROM getaways".$where."
            ORDER BY start_date ASC, start_time DESC")->execute();

            if(count($result) > 0)
                return $result;
        }

        return false;
    }

    public static function get_distinct_getaway_states() {
        $result = \Fuel\Core\DB::query("SELECT distinct state from getaways where "
            . "get_away_end_date >= curdate()")->execute();

        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    public static function get_getaways_by_location($location = null) {
        $result = \Fuel\Core\DB::query("SELECT id, title, slug, long_description, short_description, url,venue,
            DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
            country, state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at from getaways where"
            . " (country like '%" . $location . "%')".  " and (get_away_end_date >= curdate())")->execute();

        if (count($result) > 0) {
            return $result;
        }
        return false;
    }
    public static function get_getaways_by_location_and_date($location = null, $start_date = null, $end_date = null) {
        $result = \Fuel\Core\DB::query("SELECT id, title, slug, long_description, short_description, url,venue,
            DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
            country, state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at from getaways where"
            . " (country like '%" . $location . "%')".  " and "
            . "(get_away_end_date >= '" . $start_date . "') and (get_away_end_date <='" . $end_date."')")->execute();

        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

}
