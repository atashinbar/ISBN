<?php

namespace Actions;

use Helper\Core;
use Helper\IsbnList;

class Register
{

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
            'menu_name'             => esc_html__('Books' , 'isbn'),
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
            'menu_icon'             => 'dashicons-book-alt',
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
            'name'                       => _x( 'Authors', 'taxonomy general name', 'isbn' ),
            'singular_name'              => _x( 'Author', 'taxonomy singular name', 'isbn' ),
            'search_items'               => __( 'Search Authors', 'isbn' ),
            'popular_items'              => __( 'Popular Authors', 'isbn' ),
            'all_items'                  => __( 'All Authors', 'isbn' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Author', 'isbn' ),
            'update_item'                => __( 'Update Author', 'isbn' ),
            'add_new_item'               => __( 'Add New Author', 'isbn' ),
            'new_item_name'              => __( 'New Author Name', 'isbn' ),
            'separate_items_with_commas' => __( 'Separate Authors with commas', 'isbn' ),
            'add_or_remove_items'        => __( 'Add or remove Authors', 'isbn' ),
            'choose_from_most_used'      => __( 'Choose from the most used Authors', 'isbn' ),
            'not_found'                  => __( 'No Authors found.', 'isbn' ),
            'menu_name'                  => __( 'Authors', 'isbn' ),
        );

        $Args = array(
            'hierarchical'          => true,
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
            'name'                       => _x( 'Publishers', 'taxonomy general name', 'isbn' ),
            'singular_name'              => _x( 'Publisher', 'taxonomy singular name', 'isbn' ),
            'search_items'               => __( 'Search Publishers', 'isbn' ),
            'popular_items'              => __( 'Popular Publishers', 'isbn' ),
            'all_items'                  => __( 'All Publishers', 'isbn' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Publisher', 'isbn' ),
            'update_item'                => __( 'Update Publisher', 'isbn' ),
            'add_new_item'               => __( 'Add New Publisher', 'isbn' ),
            'new_item_name'              => __( 'New Publisher Name', 'isbn' ),
            'separate_items_with_commas' => __( 'Separate Publishers with commas', 'isbn' ),
            'add_or_remove_items'        => __( 'Add or remove Publishers', 'isbn' ),
            'choose_from_most_used'      => __( 'Choose from the most used Publishers', 'isbn' ),
            'not_found'                  => __( 'No Publishers found.', 'isbn' ),
            'menu_name'                  => __( 'Publishers', 'isbn' ),
        );

        $Args = array(
            'hierarchical'          => true,
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
            esc_html__( 'ISBN Number', 'isbn' ),
            array( $this, 'MetaBox_Callback' ),
            $this->Type
        );
    }

    
    public function MetaBox_Callback( $post )
    {
        // Security
        wp_nonce_field( 'IsbnMeta', 'IsbnMetaNonce' );

        // Gets Post meta
        $value = get_post_meta( $post->ID, '_book_isbn', true );

        // Render Input
        echo '<input type="text" name="book_isbn" value="'.$value.'" />';
    }

    public function save_metabox_callback( $post_id )
    {
        // Get Nonce
        $Nonce   = isset( $_POST['IsbnMetaNonce'] ) ? $_POST['IsbnMetaNonce'] : '';
        $NonceAction = 'IsbnMeta';
    
        if ( ! isset( $Nonce ) ) {
            return;
        }
    
        if ( ! wp_verify_nonce( $Nonce, $NonceAction ) )
        {
            return;
        }
    
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        {
            return;
        }
    
        if ( ! current_user_can( 'edit_post', $post_id ) )
        {
            return;
        }


        if ( isset( $_REQUEST['book_isbn'] ) )
        {
            // Update Post meta
            update_post_meta( $post_id, '_book_isbn', sanitize_text_field( $_POST['book_isbn'] ) );

            // Insert/Update "books_info" Database
            $WpDB       = Core::GetWPDB();
            $Table      = $WpDB->prefix . 'books_info';

            $Result = $WpDB->get_results(
                "SELECT
                COUNT(*) AS TOTALCOUNT
                FROM {$Table}
                WHERE ( post_id = $post_id )"
            );

            $Count = $Result[0]->TOTALCOUNT; //Check Duplicate

            // if the count return 1, do nothing, but else insert the data
            if( $Count > 0 )
            {
                //Update Table
                $WpDB->update( 
                    $Table, 
                    array( 
                        'isbn'      => $_POST['book_isbn']
                    ),
                    array(
                        'post_id'   =>$post_id
                    )
                );
            } else {
                // New row in table
                $WpDB->insert( 
                    $Table, 
                    array( 
                        'post_id'   => $post_id, 
                        'isbn'      => sanitize_text_field( $_POST['book_isbn'] ), 
                    ) 
                );
            }
        }

    }

    /**
    * Add submenu
    */
    public function register_sub_menu()
    {
        add_submenu_page(
            sprintf('edit.php?post_type=%s' , $this->Type),
            _x( 'ISBNs', 'ISBN page title', 'isbn' ),
            _x( 'ISBNs', 'ISBN menu title', 'isbn' ),
            'manage_options',
            'isbn',
            array($this, 'IsbnPageContent')
        );
    }

    /**
    * ISBN page Content
    */ 
    public function IsbnPageContent() 
    {   
        $newdb = new IsbnList();
        $newdb->prepare_items();
        include_once plugin_dir_path(__FILE__) . 'Page.php';
    }


    public function __construct()
    {
        // Register the post type
        add_action('init', array($this, 'RegisterPostType'));

        // Add Author Taxonomy
        add_action('init', array($this, 'RegisterAuthorTaxonomy'));

        // Register Publishe Taxonomy
        add_action('init', array($this, 'RegisterPublisherTaxonomy'));

        // Add Metabox
        add_action( 'add_meta_boxes', array($this, 'RegisterMetaBox') );

        // Save Metabox
        add_action( 'save_post', array($this, 'save_metabox_callback') );

        add_action( 'admin_menu', array($this, 'register_sub_menu') );
    }
}