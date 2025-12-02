<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$config = new \App\Service\Config();

$templating = new \App\Service\Templating();
$router = new \App\Service\Router();

// Inicjalizujemy $view jako null, aby uniknąć błędu "Undefined variable" 
// w przypadku, gdy żaden case nie zwróci widoku (np. przez brak ID).
$view = null;

$action = $_REQUEST['action'] ?? null;

switch ($action) {
    case 'post-index':
    case null:
        $controller = new \App\Controller\PostController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'post-create':
        $controller = new \App\Controller\PostController();
        $view = $controller->createAction($_REQUEST['post'] ?? null, $templating, $router);
        break;
    case 'post-edit':
        // Używamy empty() zamiast wykrzyknika. empty() nie wyrzuci błędu, jeśli klucz nie istnieje.
        if (empty($_REQUEST['id'])) {
            $view = $templating->render('error.html.php', ['message' => 'Missing Post ID']); // Opcjonalnie: ładniejszy błąd
            break;
        }
        $controller = new \App\Controller\PostController();
        $view = $controller->editAction((int)$_REQUEST['id'], $_REQUEST['post'] ?? null, $templating, $router);
        break;
    case 'post-show':
        if (empty($_REQUEST['id'])) {
            break;
        }
        $controller = new \App\Controller\PostController();
        $view = $controller->showAction((int)$_REQUEST['id'], $templating, $router);
        break;
    case 'post-delete':
        if (empty($_REQUEST['id'])) {
            break;
        }
        $controller = new \App\Controller\PostController();
        $view = $controller->deleteAction((int)$_REQUEST['id'], $router);
        break;

    // --- Sekcja Komentarzy ---
    case 'comment-index':
        $controller = new \App\Controller\CommentController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'comment-create':
        $controller = new \App\Controller\CommentController();
        $view = $controller->createAction($_REQUEST['comment'] ?? null, $templating, $router);
        break;
    case 'comment-edit':
        if (empty($_REQUEST['id'])) {
            break;
        }
        $controller = new \App\Controller\CommentController();
        $view = $controller->editAction((int)$_REQUEST['id'], $_REQUEST['comment'] ?? null, $templating, $router);
        break;
    case 'comment-show':
        if (empty($_REQUEST['id'])) {
            break;
        }
        $controller = new \App\Controller\CommentController();
        $view = $controller->showAction((int)$_REQUEST['id'], $templating, $router);
        break;
    case 'comment-delete':
        if (empty($_REQUEST['id'])) {
            break;
        }
        $controller = new \App\Controller\CommentController();
        $view = $controller->deleteAction((int)$_REQUEST['id'], $router);
        break;
    // -------------------------

    case 'info':
        $controller = new \App\Controller\InfoController();
        $view = $controller->infoAction();
        break;
    default:
        $view = 'Not found';
        break;
}

if ($view) {
    echo $view;
}