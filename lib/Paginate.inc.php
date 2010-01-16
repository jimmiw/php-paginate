<?php

class Paginate {
  private $table_name;
  private $current_page;
  private $items_per_page;
  
  public function __construct($table_name, $current_page, $items_per_page) {
    $this->table_name = $table_name;
    $this->current_page = $current_page;
    $this->items_per_page = $items_per_page;
  }
  
  /**
   * @returns a suggested offset to use in the SQL, based on the values
   * set in the constructor
   */
  public function getOffset() {
    $offset = 0;
    
    if($this->current_page > 1) {
      $offset = ($this->current_page-1)*$this->items_per_page;
    }
    
    return $offset;
  }
  
  /**
   * @returns the current page
   */
  public function getCurrentPage() {
    return $this->current_page;
  }
  
  /**
   * @returns the number of items per page
   */
  public function getItemsPerPage() {
    return $this->items_per_page;
  }
  
  /**
   * @returns the total number of pages (does a mysql select, so remember to
   * connect to the database first!)
   */
  public function getTotalPages() {
    $total_pages = 0;
    
    try {
      $row = mysql_fetch_array(mysql_query("select count(*) from ".$this->table_name));
      $total_pages = $row[0];
    }
    catch(Exception $e) {
    
    }
    
    return $total_pages;
  }
}

?>
