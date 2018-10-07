<?php

namespace Helper;

use Helper\Core;

class GetIsbn
{
    public function ISBNs()
    {
        $WpDB       = Core::GetWPDB();
        $Table      = $WpDB->prefix . 'books_info';
        $AllISBN    = $WpDB->get_results( "SELECT * FROM $Table" );
        $ISBN       = array();
        $Out        = array();
        foreach ($AllISBN as $ISBNS) {
            $Out[] = json_decode(json_encode($ISBNS), True);         
        }
        return $Out;
    }
}