<?php
/**
 * Author: Andreas Geisler
 * Date: 06.06.16
 *
 * Description:
 * DB class representing the entry
 */

namespace Google;

class Entry
{
    private $id;
    private $title = '';
    private $link = '';
    private $published = '';
    private $content = '';
    private $author = '';

    public function __construct(\SimpleXMLElement $data)
    {
        $this->published = $data->published;
        $this->author = (string)$data->author->name;

        $this->setId($data->id);
        $this->setTitle($data->title);
        $this->setContent($data->content);
        $this->setLink($data->link->attributes()->href);
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id =  str_replace("tag:google.com,2013:googlealerts/feed:", "", $id);
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $content = str_replace("&nbsp;", " ", (string)$content);
        $content = strip_tags($content);
        $this->content = utf8_decode($content);
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $title = strip_tags((string)$title);
        $this->title = utf8_decode($title);
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = str_replace("https://www.google.com/url?rct=j&sa=t&url=", "", $link);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \SimpleXMLElement[]|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @return \SimpleXMLElement[]|string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }
}