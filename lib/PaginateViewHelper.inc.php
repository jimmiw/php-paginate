<?php

/**
 * Defines a pagination class called Paginate.
 * 
 * NOTE: Only works with MySQL atm!
 */
class PaginateViewHelper {
  private $currentPage;
  private $itemsPerPage;
  private $linkPrefix;
  private $totalItems;
  private $nextText;
  private $previousText;
  
  /**
   * initializes the paginate class, using a default value of
   * 10 items per page displayed.
   */
  public function __construct($currentPage = 1, $itemsPerPage = 10, $totalItems, $linkPrefix = "/page/") {
    $this->currentPage = $currentPage;
    $this->itemsPerPage = $itemsPerPage;
    $this->linkPrefix = $linkPrefix;
    $this->totalItems = $totalItems;
    $this->nextText = "Next &raquo;";
    $this->previousText = "&laquo; Previous";
  }
  
  /** 
   * Sets the text to be displayed in the next link
   * @param $text, the text to be displayed instead of the standard text
   */
  public function setNextText($text) {
    $this->nextText = $text;
  }
  
  /** 
   * Sets the text to be displayed in the previous link
   * @param $text, the text to be displayed instead of the standard text
   */
  public function setPreviousText($text) {
    $this->previousText = $text;
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
  public function render() {
    // @params $table_name, the name of the table to do the pagination on.
    // finds the total amount of items
    /*$row = mysql_fetch_array(mysql_query("select count(*) from ".$table_name));
    $count = $row[0];*/
    
    // finds the total amount of pages, using the number of items, dividing them
    // by the number of items per page.
    // uses a round to make it a pretty integer
    $totalPageCount = round($this->totalItems / $this->itemsPerPage);
    
    // constructs the html to use for the pagination view.
    $html = "<ul class=\"paginate\">";
    // if it's not the first page, then add a < link
    if($this->currentPage > 1) {
      $html .= $this->createLink(1, $this->previousText, false);
    }
    // adds the page links, one by one
    for($i = 1; $i <= $totalPageCount; $i++) {
      $html .= $this->createLink($i);
    }
    // if it's not the last page, then add a > link
    if($this->currentPage < $totalPageCount) {
      $html .= $this->createLink(($this->currentPage + 1), $this->nextText, false);
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
  private function createLink($pageNumber, $linkValue = null, $colorSelected = true) {
    // if no different link_value was set, use the page number.
    if($linkValue == null) {
      $linkValue = $pageNumber;
    }
  
    $htmlLink = "<li><a href=\"".$this->linkPrefix.$pageNumber."\"";
    
    // if the current page and page number are equal, add a selected class
    if($pageNumber == $this->currentPage && $colorSelected) {
      $htmlLink .= " class=\"selected\"";
    }
    
    $htmlLink .= ">".$linkValue."</a></li>";
    
    return $htmlLink;
  }
}

?>
