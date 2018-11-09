<?php
namespace App\HTML;

class BootstrapForm extends Form {

    /**
     * @param $html
     * @return string code html a entourer (bootstrap)
     */
    protected function surround($html) {
        return "<div class=\"form-group\">$html</div>";
    }

    /**
     * @param $name
     * @return string champ input de formuaire
     */
    public function input($label, $name, $option = [], $value = false, $echoValue = null, $isRequired = false,  $row = null) {
        // on précise le type si l'on veut modifier le input
        $type = isset($option['type']) ? $option['type'] : 'text';
        // affichage du label.
        $label = '<label for="' . $name . '">'. $label . '</label>';

        // si value est true, on veut que le formulaire afficher les valeurs passés
        if ($value === true){
            // si $echovalue est présente on affiche cette valeur
            if (isset($echoValue)) {
                $message = $echoValue;
            } else { // sinon on affiche la valeur passé dans le formulaire
                $message = $this->getValue($name);
            }
        } else {
            $message = '';
        }

        if ($isRequired === true) {
            $required = 'required';
        } else {
            $required = '';
        }


        // si row est présent on affecte un nombre de ligne à textarea.
        if (isset($row)) {
            $rows = $row;
        } else {
            $rows = null;
        }
        // si $type = textarea on affiche un textarea
        if ($type === 'textarea') {
            $input = '<textarea name="' . $name . '" 
            id="' . $name . '" class="form-control" rows="'. $rows .'" ' . $required . '>'. $message . '</textarea>';
       } else { // sinon on affiche un input classique
            $input = '<input type="' . $type . '" name="' . $name . '" value="' . $message .'" 
            id="' . $name . '" class="form-control" '. $required . '>';
        }
        return $this->surround($label . $input);
    }

    /**
     * @return string champ submit de formulaire
     */
    public function submit($label)
    {
        return $this->surround('<input type="submit" name="submit" class="btn btn-primary" value="'. $label .'">');
    }


    }