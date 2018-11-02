<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:59
 */

namespace App\src\DAO;

use App\config\Config;
use \PDO;
use \Exception;

abstract class DAO
{
    private $db;

    protected function checkConnection()
    {
        //Vérifie si la connexion est null et fait appel à getDB()
        if ($this->db === null) {
            $this->db = $this->getDB();
        }
        //Si la connexion existe, elle est renvoyée, inutile de refaire une connexion
        return $this->db;
    }


    public function getDB()
    {
        // tentative de connexion à la db
        try {
            $config = Config::getInstance(ROOT . '/config/dev.php');
            $db_instance = new PDO('mysql:host=' . $config->get('db_host') . ';dbname=' . $config->get('db_name') .
                ';charset=' . $config->get('db_charset'), $config->get('db_user'), $config->get('db_pass'));
            return $db_instance;

        } // si echec on lève une erreur.
        catch (Exception $errorConnection) {
            die ('Erreur de connexion : ' . $errorConnection->getMessage());
        }
    }
}