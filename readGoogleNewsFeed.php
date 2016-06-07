<?php
/**
 * User: Andreas Geisler
 * Date: 05.06.16
 *
 * Starter file for reading Google news feed
 */
require("config.php");
require("autoload.php");
use Google\Feed;

$googleFeed = new Feed(FEEDURL);
$googleFeed->read();

$entries = $googleFeed->getEntries();

foreach( $entries as $entry ) {
    $dbEntry = new \DB\Entry($entry);
    $dbEntry->write();
}