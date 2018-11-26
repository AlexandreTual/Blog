<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:59
 */

namespace app\src\dao;

use app\config\Config;
use Exception;
use PDO;

abstract class DAO
{
    private $db;

    public function checkConnection()
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
            $db_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db_instance;

        } // si echec on lève une erreur.
        catch (Exception $errorConnection) {
            die ('Erreur de connexion : ' . $errorConnection->getMessage());
        }
    }
}