<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27/11/2018
 * Time: 13:16
 */

namespace app\src\controller;

use app\core\Utils;

class CategoryController extends Controller
{
    public function addCategory($post)
    {
        if (Utils::checkField(['name'], $post)) {
            $category = $this->categoryDAO->add($post);
            if ($category) {
                Utils::messageSuccess('Catégorie ajouté avec succès', 'admin');
            } else {
                Utils::messageError('Une erreur c\'est produite veuillez recommencer.', 'admin');
            }
        }
    }

}