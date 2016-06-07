<?php
/**
 * Author: Andreas Geisler
 * Date: 06.06.16
 *
 * Description:
 * DB class representing the entry
 */

namespace DB;

class Entry extends DB
{
    private $id;
    private $title = "";
    private $link = '';
    private $published = '';
    private $content = '';
    private $author = '';

    public function __construct( \Google\Entry $entry )
    {
        parent::__construct();

        $this->table = 'news_entry';
        $this->id = str_replace("tag:google.com,2013:googlealerts/feed:", "", $entry->getId());
        $this->title = $entry->getTitle();
        $this->link = $entry->getLink();
        $this->published = $entry->getPublished();
        $this->content = $entry->getContent();
        $this->author = $entry->getAuthor();
    }

    public function write() {
        parent::write(
            array(
                'id' => $this->id,
                'title' => $this->title,
                'link' => $this->link,
                'published' => $this->published,
                'content' => $this->content,
                'author' => $this->author
            )
        );
    }
}