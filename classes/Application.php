<?php

/* class Application
 * Contains static fields and functions which affect the entire application.
 */

class Application {

  /* panic([$message])
   * Stop everything we're doing and quit with an optional message.
   */
  public static function panic($message = false) {
    if($message)
      exit($message);
    else
      exit();
  }
}
