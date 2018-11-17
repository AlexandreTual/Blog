<?php

namespace App\HTML;

class BootstrapForm extends Form
{

    /**
     * @param $name
     * @return string champ input de formuaire
     */
    public function input($label, $name, $option = [], $value = false, $echoValue = null, $isRequired = false,
                          $row = null, $wysiwyg = null, $id = null, $placeholder = null)
    {
        // on précise le type si l'on veut modifier le input
        $type = isset($option['type']) ? $option['type'] : 'text';
        // affichage du label.
        $label = '<label for="' . $name . '">' . $label . '</label>';
        // si value est true, on veut que le formulaire afficher les valeurs passés
        if ($value === true) {
            // si $echovalue est présente on affiche cette valeur
            if (isset($echoValue)) {
                $message = $echoValue;
            } else { // sinon on affiche la valeur passé dans le formulaire
                $message = $this->getValue($name);
            }
        } else {
            $message = '';
        }
        // si l'on souhaite que le navigateur n'envoi pas le formulaire si le champ n'est pas rempli.
        $required = ($isRequired == true) ? 'required' : '';
        // si row est présent on affecte un nombre de ligne à textarea.
        $rows = (isset($row)) ? $row : null;
        // si l'on souhaite que le ne textarea utilise un éditeur de HTML de type WYSIWYG
        $nameWysiwyg = (!empty($wysiwyg)) ? $wysiwyg : '';
        // si l'on souhaite définir l'id.
        $id = (empty($id)) ? $name : $id;
        $placeholder = (isset($placeholder) ? $placeholder : '');
        // si $type = textarea on affiche un textarea
        if ($type === 'textarea') {
            $input = '<textarea name="' . $name . '" 
            id="' . $id . '" class="form-control" rows="' . $rows . '" ' . $required . ' ' . $nameWysiwyg . '>' . $message . '</textarea>';
        } else { // sinon on affiche un input classique
            $input = '<input type="' . $type . '" name="' . $name . '" value="' . $message . '" 
            id="' . $name . '" class="form-control" ' . $required . ' placeholder="' . $placeholder .'">';
        }
        return $this->surround($label . $input);
    }

    /**
     * @param $html
     * @return string code html a entourer (bootstrap)
     */
    protected function surround($html)
    {
        return "<div class=\"form-group\">$html</div>";
    }

    /**
     * @return string champ submit de formulaire
     */
    public function submit($label, $option = null)
    {
        return $this->surround('<input type="submit" name="submit" class="btn '. $option.'" value="' . $label . '">');
    }

    public function select($options, $name, $label = null, $selected = null)
    {
        $label = '<label for="'. $name . '">' . $label . '</label>';
        $selector = '';
        foreach ($options as $v) {
            $selector .= '<option value="' . $v->getId() . '">' . ucfirst($v->getName()) . '</option>';
        }
        $select = '<select class="custom-select" name="'.$name.'" id="'.$name.'">
                   '. $selector .'
                   </select>';
        return $this->surround($label.$select);
    }


}