<?php

class Project {

  public $name;
  public $path;
  public $base_url;
  private $md_extended;
  private $metas_cache;

  function __construct($name, $path, $base_url, $data=NULL) {
    $this->name = $name;
    $this->path = $path;
    $this->base_url = $base_url;
    if ($data !== NULL) $this->set_data($data);
  }

  /**
   * Whether the project is external or not.
   *
   * @returns TRUE if the project is public, FALSE otherwise.
   */
  public function is_external() {
    $metas = $this->metas();
    return !empty($metas['external']);
  }

  /**
   * @returns a MarkdownExtended instance
   */
  private function get_markdown_parser($data) {
    return \MarkdownExtended\MarkdownExtended::create([
      'html_empty_element_suffix' => '>',
    ])->transformString($data);
  }

  /**
   * Resize and writes an image to create the preview image
   *
   * @param $path The image to resize
   * @param $width The preview width
   */
  private function resize_to_preview($path, $width) {
    $thumb = new Imagick($path);
    $thumb->resizeImage($width, 0, Imagick::FILTER_LANCZOS, 1);
    $thumb->writeImage("$this->path/preview.jpg");
  }

  /**
   * Updates the MarkdownExtended with a new source
   */
  function set_data($data) {
    $this->md_extended = $this->get_markdown_parser($data);
  }

  /**
   * @returns An array containing the parsed metas
   */
  function metas() {
    if (!$this->metas_cache) {
      $this->metas_cache = $this->md_extended->getMetadata();
    }
    return $this->metas_cache;
  }

  /**
   * @returns A string containing the HTML result of the Markdown description
   */
  function html() {
    return trim($this->md_extended->getBody());
  }

  /**
   * @returns the project URL
   */
  function url() {
    if ($this->is_external()) {
      $metas = $this->metas();
      return $metas['external'];
    }
    return "/$this->name";
  }

  /**
   * @returns An array containing all the images names of a project
   */
  function images_names() {
    $images = glob("$this->path/images/*.jpg");
    return array_map(function($image) {
      return basename($image);
    }, $images);
  }

  /**
   * @returns an array containing all the images in objects (url, dimensions)
   */
  function images() {
    $images = $this->images_names();
    $images = array_map(function($name) {
      return $this->image_object("$this->path/images/$name",
        "$this->base_url/images/$name");
    }, $images);
    return $images;
  }

  /**
   * @param $path the image path on the filesystem
   * @param $url the image URL
   * @returns an image object (url, width, height)
   */
  private function image_object($path, $url) {
    $size = getimagesize($path);
    return (object)[
      "url" => $url,
      "width" => $size[0],
      "height" => $size[1],
    ];
  }

  /**
   * Tries to find the best image to use for the preview image
   * @returns A string corresponding to the best fit image name
   */
  private function find_preview_name() {
    $metas = $this->metas();
    if (!empty($metas['thumbnail'])) {
      $name = $metas['thumbnail'];
      if (file_exists("$this->path/images/$name")) return $name;
    }
    $images = $this->images_names();
    return $images[0];
  }

  /**
   * Creates the preview image if it does not exists, and returns an object
   * corresponding to the preview image.
   *
   * @param $width The desired width, if a resize is triggered
   * @returns An image object corresponding to the preview image
   */
  function preview($width) {
    if (!file_exists("$this->path/preview.jpg")) {
      $thumbnail = $this->find_preview_name();
      $this->resize_to_preview("$this->path/images/$thumbnail", $width);
    }
    return $this->image_object("$this->path/preview.jpg",
      "$this->base_url/preview.jpg");
  }
}

