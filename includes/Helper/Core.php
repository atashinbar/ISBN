<?php

namespace Helper;

class Core
{
    /**
     * @return mixed
     */
    public static function getRandomEmoji()
    {
        $items = Array(':)', ':(', ':|', ':D');

        return $items[array_rand($items)];
    }

    /**
     * Returns WordPres DB Object
     * @author Webnus <info@webnus.biz>
     * @global object $wpdb
     * @return object
     */
	public static function GetWPDB()
	{
		global $wpdb;
		return $wpdb;
	}
}