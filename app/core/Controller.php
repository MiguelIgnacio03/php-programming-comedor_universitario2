<?php
/**
 * Base Controller Class
 */
abstract class Controller {
    /**
     * Load model
     */
    public function model($model) {
        // Require model file
        $modelFile = APPROOT . '/app/models/' . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            // Instantiate model
            return new $model();
        } else {
            die("Model file not found: $modelFile");
        }
    }

    /**
     * Load view
     */
    public function view($view, $data = []) {
        // Check for view file
        $viewFile = APPROOT . '/app/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View file not found: $viewFile");
        }
    }
}
