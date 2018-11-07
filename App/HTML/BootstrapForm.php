<?php
namespace App\HTML;

class BootstrapForm extends Form {

    /**
     * @param $html
     * @return string code html a entourer
     */
    protected function surround($html) {
        return "<div class=\"form-group\">$html</div>";
    }

    /**
     * @param $name
     * @return string champ input de formuaire
     */
    public function input($label, $name, $option = [], $value = false, $echoValue = null) {
        $type = isset($option['type']) ? $option['type'] : 'text';
        $label = '<label for="' . $name . '">'. $label . '</label>';
        if ($value === true){
            if (isset($echoValue)) {
                $message = $echoValue;
            } else {

                $message = $this->getValue($name);
            }
        } else {
            $message = '';
        }
        if ($type === 'textarea') {
            $input = '<textarea name="' . $name . '" 
            id="' . $name . '" class="form-control">'. $message . '</textarea>';
       } else {
            $input = '<input type="' . $type . '" name="' . $name . '" value="' . $message .'" 
            id="' . $name . '" class="form-control">';
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