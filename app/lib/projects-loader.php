<?php

class ProjectsLoader {

  private $projects_dir;

  function __construct($projects_dir) {
    $this->projects_dir = $projects_dir;
  }

  private function get_names() {
    $projects_dirs = glob("$this->projects_dir/*" , GLOB_ONLYDIR);
    $projects_dirs = array_map(function($dir) {
      return basename($dir);
    }, $projects_dirs);
    return $projects_dirs;
  }

  private function project_exists($name) {
    $names = $this->get_names();
    return in_array($name, $names);
  }

  private function project_path($name) {
    return "$this->projects_dir/$name";
  }

  function get($name) {
    if (!$this->project_exists($name)) return NULL;
    $path = $this->project_path($name);
    $data = file_get_contents("$path/project.md");
    if ($data === FALSE) return NULL;
    return new Project($name, $path, $data);
  }

  function get_all() {
    $projects_names = $this->get_names();
    $projects = [];
    foreach ($projects_names as $name) {
      $project = $this->get($name);
      if ($project) $projects[] = $project;
    }
    return $projects;
  }
}

