<?php
namespace App\Controllers;

class NotFoundController extends BaseController {
    public function ActionIndex() {
        return $this->renderPage('service/notFound', [], 'views/templateFull');
    }
}