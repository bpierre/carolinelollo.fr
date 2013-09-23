<?php
require __DIR__ . '/../vendor/autoload.php';

// App
$app = new Bullet\App([
  'template' => [
    'path' => __DIR__ . '/views/',
    'path_layouts' => __DIR__ . '/views/layout/',
    'auto_layout' => 'main'
  ]
]);

$projects_loader = new ProjectsLoader(__DIR__.'/../public/projects');

// Home
$app->path('/', function($request) use($app, $projects_loader) {
  $projects = $projects_loader->get_all();
  $template = $app->template('home');
  $template->set('html_classes', '');
  $template->set('projects', $projects);
  return $template;
});

$app->path('/about', function($request) use($app) {
  return $app->template('about')->set([
    'html_classes' => 'page',
  ]);
});

// Projects
$app->param('slug', function($request, $project_name) use($app, $projects_loader) {
  $app->get(function($request) use($app, $project_name, $projects_loader) {
    $project = $projects_loader->get($project_name);
    if (!$project) return FALSE;
    $html_classes = 'single';
    if (!trim($project->html())) $html_classes .= ' no-description';
    return $app->template('project')->set([
      'next_project' => $projects_loader->get_next($project_name),
      'prev_project' => $projects_loader->get_prev($project_name),
      'project' => $project,
      'html_classes' => $html_classes,
    ]);
  });
});

// Static page
$app->path('/test', function($request) use($app, $projects_loader) {
  var_dump($projects_loader->get_all());
  var_dump($projects_loader->get('the-fat-fat-club'));
  return '';
});

// Run app
echo $app->run(new Bullet\Request());

