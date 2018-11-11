<?php
namespace App\HTML;;

class Form {

    /**
     * @var array données utlisées dans le formulaire
     */
    private $data;
    /**
     * @var string tag utilisé pour entourer les champs
     */
    public $surround = 'p';

    /**
     * Form constructor.
     * @param array $data données utilisés dans le formulaire
     */
    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * @param $html
     * @return string code html a entourer
     */
    protected function surround($html) {
        return "<{$this->surround}>$html</{$this->surround}>";
    }

    /**
     * @param $index
     * @return mixed|null value a retourner dans le champs input
     */
    protected function getValue($index) {
        if (is_object($this->data)) {
            return $this->data->$index;
        }
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    /**
     * @param $name
     * @return string champ input de formuaire
     */
    public function input($label, $name, $option = []) {
        $type = isset($option['type']) ? $option['type'] : 'text';
        return $this->surround('<input type="' . $type . '" name="' . $name . '" value="' . $this->getValue($name) .'">');
    }



    /**
     * @return string champ submit de formulaire
     */
    public function submit($label) {
        return $this->surround('<input type="submit">'. $label . '</input>');
    }
}