<?php

namespace Helper;

class Core
{
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