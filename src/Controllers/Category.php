<?php
require_once __DIR__ . '/../Models/Database.php';
class Category
{
    public function add($category, $id)
    {
        $res = [];
        $empty = 0;
        $cat = '';
        $check = (new Database())->checkCategory($category['category'], $id);
        foreach ($category as $detail) {
            if (empty($detail)) {
                $empty++;
            }
        }
        if ($empty > 0) {
            $res['error'] = "Input Fields cant be empty";
        } elseif ($check) {
            $res['error'] = "Category Already Exists";
        } else {
            $cat = (new Database())->addCategory($category, $id);
            if ($cat) {
                $res['success'] = "Category Successfully Added";
            }
        }
        return $res;
    }
    public function update($id, $category)
    {
        $res = [];
        $empty = 0;
        $cat = '';
        if (empty($category)) {
            $empty++;
        }
        if ($empty > 0) {
            $res['error'] = "Input Fields cant be empty";
        } else {
            $cat = (new Database())->updateCategory($id, $category);
            if ($cat) {
                $res['success'] = "Category Saved Successfully";
            }
        }
        return $res;
    }
    public function delete($id)
    {
        $res = (new Database())->deleteCategory($id);
        return $res;
    }
}
