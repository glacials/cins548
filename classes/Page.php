<?php

/* class Page
 * The purpose of this class is to act as a connection between page logic and
 * raw HTML. To display a page, you should write raw HTML in a file in the
 * "html" directory. Wherever you want some dynamic page content, use curly
 * braces ("{}") around a word. This class will replace that word at run time
 * with whatever you tell it to, and give you back the changed HTML with our
 * HTML headers and footers tacked on. See the __construct function comments
 * for more instructions.
 */
class Page {

  private $file;
  private $page_vars;
  private $surround;

  /* __construct($file, $page_vars = false)
   * Outputs the contents of 'html/$file', replacing certain keywords with
   * content as specified by the array $page_vars.
   *
   * For instance, if $page_vars is the array:
   *   'product_name'  => 'Coffee table book'
   *   'product_desc'  => 'A coffee table book about coffee tables'
   *   'product_price' => 39.99
   * then the Page will replace all instances of "{product_name}" in $file with
   * "Coffee table book", etc. (note the curly braces).
   *
   * If $page_vars is not passed (e.g. via "new Page('index.html')") then no
   * replacements are made.
   *
   * If $surround is true (default when not passed), the header and footer are
   * inserted around the page's HTML when it is output. If it is false, they are
   * not.
   */
  public function __construct($file, $page_vars = array(), $surround = true) {
    // If someone tries to include some file not in the "html" directory, panic
    if (strstr($file, '..'))
      Application::panic('You can\'t run pages not in the "html" directory.');
    $this->file = $file;
    $this->page_vars = $page_vars;
    $this->surround = $surround;
  }

  /* __get($var)
   * This function is just so we can call 0-argument methods without using
   * parentheses, e.g. "$page->html".
   *
   * Check out http://php.net/__get if you want to see how it works.
   */
  public function __get($var) {
    return $this->$var();
  }

  /* html()
   * Returns the resulting HTML from processing this page. Specifically, reads
   * in html/header.html, $this->file, and html/footer.html, concatenates them
   * in that order, and replaces any occurrences of '{any_string}' with the
   * corresponding value in $this->page_vars. If there isn't one, the occurrence
   * is removed.
   */
  public function html() {
    $html = '';
    if ($this->surround)
      $html .= file_get_contents('html/header.html') . "\n";
    $html .= file_get_contents('html/' . $this->file) . "\n";
    if ($this->surround)
      $html .= file_get_contents('html/footer.html');
    foreach ($this->page_vars as $key => $val)
      $html = str_replace('{' . $key . '}', $val, $html);
    $html = preg_replace('/\{(.*)\}/', '', $html);
    return $html;
  }

}

?>
