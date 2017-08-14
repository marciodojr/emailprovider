<?php

namespace IntecPhp\View;


use IntecPhp\Model\Config;

/**
 * Description of Layout
 *
 * @author intec
 */
class Layout
{

    private $stylesheets;
    private $scripts;
    private $metaKeywords;
    private $metaDescription;
    private $metaAuthor;

    private $metaOgDataArray = [
        'name' => '',
        'photo_url' => '',
        'url' => '',
        'description' => ''
    ];

    private $title = '';

    private $contentId;
    private $layout;
    private $renderLayout = true;

    const DEFAULT_LAYOUT = 'layout';

    public function __construct($layoutName = self::DEFAULT_LAYOUT, $stylesheets = [], $scripts = [])
    {
        $this->stylesheets = $stylesheets;
        $this->scripts = $scripts;
        $this->layout = self::DEFAULT_LAYOUT;

        $this->metaKeywords = Config::$META_KEYWORDS;
        $this->metaDescription = Config::$META_DESCRIPTION;
        $this->metaAuthor = Config::$META_AUTHOR;

        $this->metaOgDataArray = [
            'name' => Config::$META_NAME,
            'photo_url' => Config::getMetaPhotoUrl(),
            'url' => Config::getDomain(),
            'description' => Config::$META_DESCRIPTION
        ];

        $this->title = Config::$TITLE;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    public function setRenderLayout($renderLayout)
    {
        $this->renderLayout = $renderLayout;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function appendTitle($text, $separator = ' - ')
    {
        $this->title .= $separator . $text;
    }

    public function setMetaKeywords($keywords)
    {
        $this->metaKeywords = $keywords;
        return $this;
    }

    public function setMetaDescription($description)
    {
        $this->metaDescription = $description;
        return $this;
    }

    public function setMetaOgDataArray($ogData)
    {
        $this->metaOgDataArray = $ogData;
        return $this;
    }

    public function render($page, $resp = null)
    {
        $this->contentId = $page;
        if ($this->renderLayout) {
            include_once 'app/views/partial/' . $this->layout . '.php';
        } else {
            extract($vars);
            include_once 'app/views/template/' . $page . '.php';
        }
    }

    public function addScript($path)
    {
        $this->scripts[] = $path;
        return $this;
    }

    public function addStylesheet($href)
    {
        $this->stylesheets[] = $href;
        return $this;
    }
}
