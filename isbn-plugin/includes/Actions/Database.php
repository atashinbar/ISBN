<?php

namespace Actions;

use Helper\Core;

class Database
{
    /**
     * Add Database
     */
    private function AddDatabase()
    {
        $WpDB       = Core::GetWPDB();
        $Charset    = $WpDB->get_charset_collate();
        $Table      = $WpDB->prefix . 'books_info';

        $CreateTable = "CREATE TABLE $Table (
        id int(10) NOT NULL AUTO_INCREMENT,
        post_id int(10) NOT NULL,
        isbn bigint(255),
        UNIQUE KEY  ID (id),
        UNIQUE KEY  post_id (post_id)
        ) $Charset;";

        if ( !function_exists('maybe_create_table') )
        {
            require_once ABSPATH . 'wp-admin/install-helper.php';
        }
        maybe_create_table( $Table, $CreateTable );

    }

    /**
     * Construct
     */
    public function __construct()
    {
        $this->AddDatabase();
    }
}