<?php 
 
  if ( ! defined( 'ABSPATH' ) ) 
  {
    exit;
  }
  
 if(!class_exists('WP_List_Table')){
      require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
  }

  class product_quote_List_Table extends WP_List_Table {

        function __construct(){
          global $status, $page;
                
          parent::__construct( array(
              'singular'  => 'id',     
              'plural'    => 'ids',    
              'ajax'      => false     
          ) );
        
        }

        protected function get_views() { 
          $status_links = array(
            "all"       => __("<a href='?page=Product_Quotation'>All</a>",'Product_Quotation'),
            "New"       => __("<a href='?page=Product_Quotation&status=New'>New</a>",'Product_Quotation'),
            "Approve"   => __("<a href='?page=Product_Quotation&status=Approve'>Approve</a>",'Product_Quotation'),
            "Processing"=> __("<a href='?page=Product_Quotation&status=Processing'>Processing</a>",'Product_Quotation'),
            "On hold"   => __("<a href='?page=Product_Quotation&status=On hold'>On hold</a>",'Product_Quotation'),
            "Cancelled" => __("<a href='?page=Product_Quotation&status=Cancelled'>Cancelled</a>",'Product_Quotation')
          );
          return $status_links;
        }

        function no_items() {
          _e( 'No Quote Request Data Avaliable.');
        }

        function table_data1(){
            global $wpdb;
            $table_name = $wpdb->prefix . "product_quote_request_detail";
            $question12 = $wpdb->get_results("SELECT * FROM $table_name");
            $admin_data = array();
            $admin_data1 = array();
            foreach ($question12 as $temp) {

                    $admin_data['quote_ID']     = $temp->quote_ID;
                    $admin_data['product_name'] = $temp->product_name;
                    $admin_data['user_name']    = $temp->user_name;
                    $admin_data['user_email']   = $temp->user_email;
                    $admin_data['user_phone']   = $temp->user_phone;
                    $admin_data['user_message'] = $temp->user_message;

                    $date = strtotime($temp->date);
                    $date1 = date('d/M/Y', $date);

                    $admin_data['create_at']    = $date1;
                    $admin_data['status']       = $temp->status;
                    $admin_data1[]              = $admin_data;
                    
            }
            return $admin_data1;
        }

        function column_default($item, $column_name){
          switch($column_name){
              case 'product_name':
              case 'user_name':
              case 'user_email':
              case 'user_phone':
              case 'user_message':
              case 'create_at':
              case 'status':
                  return $item[$column_name];
              default:
                  return print_r($item,true); //Show the whole array for troubleshooting purposes user_message
          }
        }

        function column_product_name($item){

            $page_na = 'my-custom-submenu-page-product-quotation';

            $actions = array(
                'id' => sprintf('<span style="color:silver">(id:%1$s)</span>',$item['quote_ID']),
                'edit'      => sprintf('<a href="?page=%s&action=%s&id=%s">Edit</a>',$page_na,'edit',$item['quote_ID']),
            );

           return sprintf('%1$s %2$s',$item['product_name'],$this->row_actions($actions));

        }

        function column_cb($item){
            return sprintf('<input type="checkbox" name="%1$s[]" value="%2$s" />',$this->_args['singular'],$item['quote_ID']);
        }

        function get_columns(){
            $columns = array(
                'cb'            => '<input type="checkbox" />', 
                'product_name'  => 'Product Name',
                'user_name'     => 'User Name',
                'user_email'    => 'User Email',
                'user_phone'    => 'User Phone',
                'user_message'  => 'Message',
                'create_at'     => 'Create At',
                'status'        => 'Status'
            );
            return $columns;
        }

        function get_sortable_columns() {
            $sortable_columns = array(
                'user_name'   => array('user_name',false), 
                'create_at'   => array('create_at',false),
                'status'      => array('status',false),
                'user_email'  => array('user_email',false),
                'product_name'=> array('product_name',false)
            );
            return $sortable_columns;
        }

        function get_bulk_actions() {
            $actions = array(
                'delete'    => 'Delete',
            );
            return $actions;
        }

        function process_bulk_action() {

            if( 'delete'===$this->current_action() ) {
              $tr = $_GET['id'];
                global $wpdb;
                $table_name = $wpdb->prefix . "product_quote_request_detail";
                foreach ($tr as $key23) {
                  $execut= $wpdb->query( $wpdb->prepare( "DELETE FROM $table_name WHERE quote_ID = %s", $key23 ) );
                }
            }
            
        }

        function prepare_items($search ='') {
            global $wpdb;

            $per_page = 10;
            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();
          
            $user = get_current_user_id();
            $screen = get_current_screen();
            $screen_option = $screen->get_option('per_page', 'option');

            $per_page = get_user_meta($user, $screen_option, true);
            if ( empty ( $per_page) || $per_page < 1 ) {
                $per_page = $screen->get_option( 'per_page', 'default' );
            }

            $this->_column_headers = array($columns, $hidden, $sortable);
            $this->process_bulk_action();
            
            $Mail_Queue = $wpdb->prefix.'product_quote_request_detail' ;
            $query = "SELECT * FROM $Mail_Queue "; 

            if(!empty($search)){
              $query .= " WHERE product_name LIKE '%{$search}%' OR user_email LIKE '%{$search}%' OR user_name LIKE '%{$search}%' OR date LIKE '%{$search}%' order by quote_ID desc";
            }

            $question12 = $wpdb->get_results($query);
            $admin_data = array();
            $admin_data1 = array();

            foreach ($question12 as $temp) {        
                    $admin_data['quote_ID']     = $temp->quote_ID;
                    $admin_data['product_name'] = $temp->product_name;
                    $admin_data['user_name']    = $temp->user_name;
                    $admin_data['user_email']   = $temp->user_email;
                    $admin_data['user_phone']   = $temp->user_phone;
                    $admin_data['user_message'] = $temp->user_message;
                    $date = strtotime($temp->date);
                    $date1 = date('Y/m/d', $date);
                    $admin_data['create_at']    = $date1;
                    $admin_data['status']       = $temp->status;

                    $admin_data1[] = $admin_data;
            }
            $data = $admin_data1;

            if (isset($_GET['status'])) {
              $status = $_GET['status'];
              $query = "SELECT * FROM $Mail_Queue Where status = '$status'";
              $question12 = $wpdb->get_results($query);
              $admin_data = array();
              $admin_data1 = array();
              foreach ($question12 as $temp) {
                      
                      $admin_data['quote_ID']     = $temp->quote_ID;
                      $admin_data['product_name'] = $temp->product_name;
                      $admin_data['user_name']    = $temp->user_name;
                      $admin_data['user_email']   = $temp->user_email;
                      $admin_data['user_phone']   = $temp->user_phone;
                      $admin_data['user_message'] = $temp->user_message;
                      $date = strtotime($temp->date);
                      $date1 = date('Y/m/d', $date);
                      $admin_data['create_at']    = $date1;
                      $admin_data['status']       = $temp->status;

                      $admin_data1[] = $admin_data;
              }
              $data = $admin_data1;
            }

            function usort_reorder($a,$b){
                $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'product_name'; 
                $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; 
                $result = strcmp($a[$orderby],$b[$orderby]); 
                return ($order==='asc') ? $result : -$result; 
            }
            usort($data, 'usort_reorder');
          
            $current_page = $this->get_pagenum();
            $total_items = count($data);
            $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
            
            $this->items = $data;
            $this->set_pagination_args( array(
                'total_items' => $total_items,                  //WE have to calculate the total number of items
                'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
                'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
            ) );

        }

  }

  function product_quote_list_page(){
      
      $testListTable = new product_quote_List_Table();

      ?>
      <div class="wrap">
          <div id="icon-users" class="icon32"><br/></div>
          <h2>Quote Request List</h2>                 

          <?php 
            $testListTable->views();
          ?>
          <form id="movies-filter" method="get">
              <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
              <?php

                if( isset($_GET['s']) ){
                  $testListTable->prepare_items($_GET['s']);
                } else {
                  $testListTable->prepare_items();
                }

                $testListTable->search_box( 'search', 'search_id-search-input' );  
                $testListTable->display();
 
              ?> 
          </form>  
      </div>
      <?php
  }

  product_quote_list_page();

 ?>