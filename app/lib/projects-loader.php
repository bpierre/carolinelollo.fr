<?php

class ProjectsLoader {

  private $projects_dir;

  function __construct($projects_dir) {
    $this->projects_dir = $projects_dir;
  }

  function remove_prefix_order($dirname) {
    return preg_replace('/^[0-9]+\-/', '', $dirname);
  }

  private function get_names($order_prefixes = TRUE) {
    $projects_dirs = glob("$this->projects_dir/*" , GLOB_ONLYDIR);
    $projects_dirs = array_filter($projects_dirs, function($dir) {
      return !preg_match('/_off$/', $dir);
    });
    $projects_dirs = array_map(function($dir) use($order_prefixes) {
      if ($order_prefixes) return basename($dir);
      return $this->remove_prefix_order(basename($dir));
    }, $projects_dirs);
    return array_reverse($projects_dirs);
  }

  private function project_exists($name) {
    $names = $this->get_names(FALSE);
    return in_array($name, $names);
  }

  private function project_path($name) {
    return "$this->projects_dir/$name";
  }

  private function name_to_prefixed($name) {
    $prefixed_names = $this->get_names(TRUE);
    foreach ($prefixed_names as $p_name) {
      if ($this->remove_prefix_order($p_name) === $name) {
        return $p_name;
      }
    }
    return NULL;
  }

  function get($name) {
    if (!$this->project_exists($name)) return NULL;
    $p_name = $this->name_to_prefixed($name);
    $path = $this->project_path($p_name);
    $data = file_get_contents("$path/project.md");
    if ($data === FALSE) return NULL;
    return new Project(
      $this->remove_prefix_order($name),
      $path, "/projects/$p_name", $data);
  }

  function get_sibling($current, $diff, $no_externals=FALSE) {
    $projects = $this->get_all($no_externals);
    foreach ($projects as $i => $project) {
      if ($project->name !== $current) continue;
      $index = $i + $diff;
      if (!isset($projects[$index])) return NULL;
      if ($no_externals && $projects[$index]->is_external()) return NULL;
      return $projects[$index];
    }
    return NULL;
  }

  function get_next($current, $no_externals=FALSE) {
    return $this->get_sibling($current, 1, $no_externals);
  }

  function get_prev($current, $no_externals=FALSE) {
    return $this->get_sibling($current, -1, $no_externals);
  }

  function get_all($no_externals=FALSE) {
    $projects_names = $this->get_names();
    $projects = [];
    foreach ($projects_names as $name) {
      $project = $this->get($this->remove_prefix_order($name));
      if ($project && !($no_externals && $project->is_external())) {
        $projects[] = $project;
      }
    }
    return $projects;
  }
}

