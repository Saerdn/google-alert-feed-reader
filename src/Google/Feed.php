<?php

/**
 * Author: Andreas Geisler
 * Date: 05.06.16
 *
 * Description:
 * Feed class representing a Google News Feed
 */
namespace Google;

use Google\Entry;
use Google\Request;

class Feed
{
    private $feedUrl = '';
    private $entries = [];
    private $id = '';
    private $title = '';


    public function __construct( $feedUrl = '') {
        $this->feedUrl = $feedUrl;
    }

    /**
     * Read the feed by calling the feed url and collect all entries.
     *
     * @param void
     * @return void
     * @throws \Exception
     */
    public function read() {
        if( $this->feedUrl == '' ) {
            throw new \Exception("Cannot read empty feed url.");
        }

        // Get data of the feed
        $request = new Request();
        $feedData = $request->getDataAsObjectFromUrl( $this->feedUrl );

        // Set feed properties and create entries
        if( !empty($feedData) ) {
            // Feed property
            $this->id = $feedData->id;
            $this->title = $feedData->title;

            // Generate the entries of the data
            $this->readEntries( $feedData->entry );
        }
    }

    /**
     * Get the Id of the feed.
     *
     * @param void
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get the title of the feed.
     *
     * @param void
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Returns list of feed entries.
     *
     * @param void
     * @returns array of \Entry
     */
    public function getEntries() {
        return $this->entries;
    }

    /**
     * Create single feed entries of the feed
     * TODO: TEST FOR SimpleXMLElement
     *
     * @param \SimpleXMLElement $entries
     * @return void
     */
    private function readEntries( \SimpleXMLElement $entries ) {

        if( empty($entries) ) {
            return;
        }

        foreach($entries as $entry) {
            // TODO: Probably better to source this replacement out
            $id = str_replace("tag:google.com,2013:googlealerts/feed:", "", $entry->id);
            $newEntry = new \Entry($entry);
            $this->entries[$id] = $newEntry;
        }
    }
}