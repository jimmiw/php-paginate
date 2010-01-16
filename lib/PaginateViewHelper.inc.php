<?php

/**
 * Defines a pagination class called Paginate.
 * 
 * NOTE: Only works with MySQL atm!
 */
class PaginateViewHelper {
  private $current_page;
  private $items_per_page;
  private $link;
  
  /**
   * initializes the paginate class, using a default value of
   * 10 items per page displayed.
   */
  public function __construct($current_page = 1, $items_per_page = 10, $link = "/page/") {
    $this->current_page = $current_page;
    $this->items_per_page = $items_per_page;
    $this->link = $link;
  }
  
  /**
   * Counts the pages and lists them on the page, using this format:
   *
   * <ul class="paginate">
   *   <li><a href="page/first"><</a></li>
   *   <li><a href="page/page_number">page_number</a></li>
   *   <li><a href="page/last">></a></li>
   * </ul>
   *
   * where "xx" is the page number
   *
   * 
   * @params $count, the total amount of items.
   */
  public function render($count) {
    // @params $table_name, the name of the table to do the pagination on.
    // finds the total amount of items
    /*$row = mysql_fetch_array(mysql_query("select count(*) from ".$table_name));
    $count = $row[0];*/
    
    // finds the total amount of pages, using the number of items, dividing them
    // by the number of items per page.
    // uses a round to make it a pretty integer
    $total_page_count = round($count / $this->items_per_page);
    
    // constructs the html to use for the pagination view.
    $html = "<ul class=\"paginate\">";
    // if it's not the first page, then add a < link
    if($this->current_page > 1) {
      $html .= $this->createLink(1, "<");
    }
    // adds the page links, one by one
    for($i = 1; $i <= $total_page_count; $i++) {
      $html .= $this->createLink($i, $pretty_url);
    }
    // if it's not the last page, then add a > link
    if($this->current_page < $total_page_count) {
      $html .= $this->createLink(($this->current_page + 1), ">");
    }
    
    $html .= "</ul>";
    return $html;
  }
  
  /**
   * Creates the link to use, including the LI tags.
   * @param $page_number, the page number to link to.
   * @param $link_value, defaults to null, use this for other link display name.
   * @returns the link created, with the LI tags.
   */
  private function createLink($page_number, $link_value = null) {
    // if no different link_value was set, use the page number.
    if($link_value == null) {
      $link_value = $page_number;
    }
  
    $html_link = "<li><a href=\"".$this->link.$page_number."\"";
    
    // if the current page and page number are equal, add a selected class
    if($page_number == $this->current_page) {
      $html_link .= " class=\"selected\"";
    }
    
    $html_link .= ">".$link_value."</a></li>";
    
    return $html_link;
  }
}

?>
