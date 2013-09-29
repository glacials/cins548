<?php

/*
 * Establish a database connection. This file's permissions should be as
 * minimal as possible! If anyone gets read access to this file it's all over.
 *
 * Create a user 'webapp' that has access to the 548webapp database with
 * password 'teamalphacins548webapp'. We will need to change this when we deploy!
 */

$db = new mysqli('localhost', 'webapp', 'teamalphacins548webapp', '548webapp');

?>
