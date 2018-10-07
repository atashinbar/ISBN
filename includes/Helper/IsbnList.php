<?php

namespace Helper;

use Helper\Core;
use Helper\GetIsbn;

class IsbnList extends \WP_List_Table
{

    protected $AllISBN = array();
    
    public function PutDataOnVariable()
    {
        $this->AllISBN = GetIsbn::ISBNs();
    }

	/**
    * __construct
	*/
    public function __construct()
    {
        $this->PutDataOnVariable();
		// Set parent defaults.
		parent::__construct( array(
			'singular' => 'isbn',     // Singular name of the listed records.
			'plural'   => 'isbns',    // Plural name of the listed records.
			'ajax'     => false,       // Does this table support ajax?
		) );
	}

    // Display Columns
    public function get_columns()
    {
		$columns = array(
			'id'        => _x( 'ISBN ID', 'Column label', 'wp-list-table-example' ),
			'post_id'   => _x( 'Post ID', 'Column label', 'wp-list-table-example' ),
			'isbn'      => _x( 'ISBN Number', 'Column label', 'wp-list-table-example' ),
		);
		return $columns;
	}
    
    
    // Sortable Item
    protected function get_sortable_columns()
    {
		$sortable_columns = array(
			'post_id'    => array( 'post_id', false ),
		);
		return $sortable_columns;
	}
    
    // Return Column Default
    protected function column_default( $item, $column_name )
    {
		switch ( $column_name ) {
			case 'id':
			case 'post_id':
			case 'isbn':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ); // Show the whole array for troubleshooting purposes.
		}
    } 
    
    // Render
    public function prepare_items()
    {
		$WpDB = Core::GetWPDB();
		$per_page = 10;
		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->process_bulk_action();
		$data = $this->AllISBN;
		usort( $data, array( $this, 'usort_reorder' ) );
		$current_page = $this->get_pagenum();
		$total_items = count( $data );
		$data = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );
		$this->items = $data;
		$this->set_pagination_args( array(
			'total_items' => $total_items,                     // WE have to calculate the total number of items.
			'per_page'    => $per_page,                        // WE have to determine how many items to show on a page.
			'total_pages' => ceil( $total_items / $per_page ), // WE have to calculate the total number of pages.
		) );
    }
    
    // Sorting
    protected function usort_reorder( $a, $b )
    {
		// If no sort, default to title.
		$orderby = ! empty( $_REQUEST['orderby'] ) ? wp_unslash( $_REQUEST['orderby'] ) : 'title'; // WPCS: Input var ok.
		// If no order, default to asc.
		$order = ! empty( $_REQUEST['order'] ) ? wp_unslash( $_REQUEST['order'] ) : 'asc'; // WPCS: Input var ok.
		// Determine sort order.
		$result = strcmp( $a[ $orderby ], $b[ $orderby ] );
		return ( 'asc' === $order ) ? $result : - $result;
	}

    
}