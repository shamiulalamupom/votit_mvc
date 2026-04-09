<?php
namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PollRepository;

class CategoryController extends Controller {
    public function list() {
        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->findAll();
        $this->render('category/list', ['categories' => $categories]);
    }

    public function show() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (!$id) {
            header('Location: /category/list/');
            exit;
        }
        $categoryRepo = new CategoryRepository();
        $category = $categoryRepo->findById($id);
        if (!$category) {
            header('Location: /category/list/');
            exit;
        }
        $pollRepo = new PollRepository();
        $polls = $pollRepo->findByCategoryId($id);
        $this->render('category/show', ['category' => $category, 'polls' => $polls]);
    }
}
