<?php

namespace Actions;

use Helper\Core;

class Register
{
    private $Name         = 'Books';
    private $SingularName = 'Book';
    private $Type         = 'book';
    private $Slug         = 'books';

    /**
     * Register post type
     */
    public function RegisterPostType()
    {
        $Labels = array(
            'name'                  => _x( 'Books', 'post type general name' ),
            'singular_name'         => _x( 'Book', 'post type singular name' ),
            'add_new'               => esc_html__('Add New' , 'isbn'),
            'all_items'             => esc_html__('All Books' , 'isbn'),
            'add_new_item'          => esc_html__('Add New Book' , 'isbn'),
            'new_item'              => esc_html__('New Book' , 'isbn'),
            'edit_item'             => esc_html__('Edit Book' , 'isbn'),
            'view_item'             => esc_html__('View Books' , 'isbn'),
            'search_items'          => esc_html__('Search Books' , 'isbn'),
            'not_found'             => esc_html__('No Books found' , 'isbn'),
            'not_found_in_trash'    => esc_html__('No Books found in Trash' , 'isbn'),
            'menu_name'             => $this->Name
        );
        $Args = array(
            'labels'                => $Labels,
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => array( 'slug' => $this->Slug ),
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => true,
            'menu_position'         => 8,
            'supports'              => array( 'title' ),
        );
        register_post_type( $this->Type, $Args );
    }

    /**
     * Register Author Taxonomy
     */
    public function RegisterAuthorTaxonomy()
    {
        $Labels = array(
            'name'                       => _x( 'Authors', 'taxonomy general name', 'textdomain' ),
            'singular_name'              => _x( 'Author', 'taxonomy singular name', 'textdomain' ),
            'search_items'               => __( 'Search Authors', 'textdomain' ),
            'popular_items'              => __( 'Popular Authors', 'textdomain' ),
            'all_items'                  => __( 'All Authors', 'textdomain' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Author', 'textdomain' ),
            'update_item'                => __( 'Update Author', 'textdomain' ),
            'add_new_item'               => __( 'Add New Author', 'textdomain' ),
            'new_item_name'              => __( 'New Author Name', 'textdomain' ),
            'separate_items_with_commas' => __( 'Separate Authors with commas', 'textdomain' ),
            'add_or_remove_items'        => __( 'Add or remove Authors', 'textdomain' ),
            'choose_from_most_used'      => __( 'Choose from the most used Authors', 'textdomain' ),
            'not_found'                  => __( 'No Authors found.', 'textdomain' ),
            'menu_name'                  => __( 'Authors', 'textdomain' ),
        );

        $Args = array(
            'hierarchical'          => false,
            'labels'                => $Labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'author' ),
        );

        register_taxonomy( 'author', $this->Type , $Args );
    }

    /**
     * Register Publisher Taxonomy
     */
    public function RegisterPublisherTaxonomy()
    {
        $Labels = array(
            'name'                       => _x( 'Publishers', 'taxonomy general name', 'textdomain' ),
            'singular_name'              => _x( 'Publisher', 'taxonomy singular name', 'textdomain' ),
            'search_items'               => __( 'Search Publishers', 'textdomain' ),
            'popular_items'              => __( 'Popular Publishers', 'textdomain' ),
            'all_items'                  => __( 'All Publishers', 'textdomain' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Publisher', 'textdomain' ),
            'update_item'                => __( 'Update Publisher', 'textdomain' ),
            'add_new_item'               => __( 'Add New Publisher', 'textdomain' ),
            'new_item_name'              => __( 'New Publisher Name', 'textdomain' ),
            'separate_items_with_commas' => __( 'Separate Publishers with commas', 'textdomain' ),
            'add_or_remove_items'        => __( 'Add or remove Publishers', 'textdomain' ),
            'choose_from_most_used'      => __( 'Choose from the most used Publishers', 'textdomain' ),
            'not_found'                  => __( 'No Publishers found.', 'textdomain' ),
            'menu_name'                  => __( 'Publishers', 'textdomain' ),
        );

        $Args = array(
            'hierarchical'          => false,
            'labels'                => $Labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'publisher' ),
        );

        register_taxonomy( 'publisher', $this->Type , $Args );
    }


    /**
     * Register ISBN Metabox
     */
    public function RegisterMetaBox()
    {
        add_meta_box(
            'book_isbn',
            __( 'ISBN Number', 'isbn' ),
            array( $this, 'MetaBox_Callback' ),
            $this->Type
        );
    }

    
    public function MetaBox_Callback( $post ) {

        // Add a nonce field so we can check for it later.
            wp_nonce_field( 'IsbnMeta', 'IsbnMetaNonce' );
    
            // Use get_post_meta to retrieve an existing value from the database.
            $value = get_post_meta( $post->ID, '_book_isbn', true );

            echo '<input type="text" name="book_isbn" value="'.$value.'" />';
    }

    public function save_metabox_callback( $post_id ) {

        $nonce_name   = isset( $_POST['IsbnMetaNonce'] ) ? $_POST['IsbnMetaNonce'] : '';
        $nonce_action = 'IsbnMeta';
    
        if ( ! isset( $nonce_name ) ) {
            return;
        }
    
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }
    
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
    
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    
        if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {
    
            // do stuff
    
        }

        // store custom fields values
        // cholesterol string
        if ( isset( $_REQUEST['book_isbn'] ) ) {
            update_post_meta( $post_id, '_book_isbn', sanitize_text_field( $_POST['book_isbn'] ) );
        }


        $WpDB       = Core::GetWPDB();
        $Table      = $WpDB->prefix . 'books_info';

        $WpDB->insert( 
            $Table, 
            array( 
                'post_id' => $post_id, 
                'isbn' => sanitize_text_field( $_POST['book_isbn'] ), 
            ) 
        );
    
        // Check if $_POST field(s) are available
    
        // Sanitize
    
        // Save
        
    }


    public function __construct()
    {
        // Register the post type
        add_action('init', array($this, 'RegisterPostType'));
        add_action('init', array($this, 'RegisterAuthorTaxonomy'));
        add_action('init', array($this, 'RegisterPublisherTaxonomy'));
        add_action( 'add_meta_boxes', array($this, 'RegisterMetaBox') );
        add_action( 'save_post', array($this, 'save_metabox_callback') );

    }
}