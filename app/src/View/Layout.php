<?php

namespace IntecPhp\View;

/**
 * Description of Layout
 *
 * @author intec
 */
class Layout
{

    private $stylesheets;
    private $scripts;
    private $metaKeywords = "keyword1, keyword2";
    private $metaDescription = "Meta description ...";
    private $metaOgDataArray = [
        'name' => 'Meta Og Name',
        'photo_url' => 'http://0.0.0.0:3000/assets/img/favicon.png',
        'url' => 'http://0.0.0.0:3000',
        'description' => 'Meta Og description ...'
    ];
    private $contentId;
    private $title = 'Page Title';
    private $layout;
    private $renderLayout = true;

    const DEFAULT_LAYOUT = 'layout';

    public function __construct($layoutName = self::DEFAULT_LAYOUT, $stylesheets = [], $scripts = [])
    {
        $this->stylesheets = $stylesheets;
        $this->scripts = $scripts;
        $this->metaDescription;
        $this->metaKeywords;
        $this->metaOgDataArray;
        $this->layout = self::DEFAULT_LAYOUT;
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
