<?php

class Project {

  public $name;
  public $path;
  public $url;
  private $md_extended;
  private $metas_cache;

  function __construct($name, $path, $url, $data=NULL) {
    $this->name = $name;
    $this->path = $path;
    $this->url = $url;
    if ($data !== NULL) $this->set_data($data);
  }

  private function get_markdown_parser($data) {
    return \MarkdownExtended\MarkdownExtended::create([
      'html_empty_element_suffix' => '>',
    ])->transformString($data);
  }

  private function resize_image($path, $width) {
    $thumb = new Imagick($path);
    $thumb->resizeImage($width, 0, Imagick::FILTER_LANCZOS, 1);
    $thumb->writeImage("$this->path/preview.jpg");
  }

  function set_data($data) {
    $this->md_extended = $this->get_markdown_parser($data);
  }

  function metas() {
    if (!$this->metas_cache) {
      $this->metas_cache = $this->md_extended->getMetadata();
    }
    return $this->metas_cache;
  }

  function html() {
    return $this->md_extended->getBody();
  }

  function images_names() {
    $images = glob("$this->path/images/*.jpg");
    return array_map(function($image) {
      return basename($image);
    }, $images);
  }

  function images() {
    $images = $this->images_names();
    $images = array_map(function($name) {
      return $this->image_object("$this->path/images/$name",
        "$this->url/images/$name");
    }, $images);
    return $images;
  }

  private function image_object($path, $url) {
    $size = getimagesize($path);
    return (object)[
      "url" => $url,
      "width" => $size[0],
      "height" => $size[1],
    ];
  }

  private function find_thumbnail_name() {
    $metas = $this->metas();
    if (!empty($metas['thumbnail'])) {
      $name = $metas['thumbnail'];
      if (file_exists("$this->path/images/$name")) return $name;
    }
    $images = $this->images_names();
    return $images[0];
  }

  function thumbnail($width) {
    if (!file_exists("$this->path/preview.jpg")) {
      $thumbnail = $this->find_thumbnail_name();
      $this->resize_image("$this->path/images/$thumbnail", $width);
    }
    return $this->image_object("$this->path/preview.jpg",
      "$this->url/preview.jpg");
  }
}

