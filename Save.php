<?php


require_once "Connection.php";


class Save {
    private $connection;

    public function  __construct() 
    {
        $this->connection = Connection::openConnection();
    }

    public function insertCategory($category) 
    {
        try {
           if ($this->rowCount($category)) {
               $save = $this->connection->prepare(" 
                   INSERT INTO categorias (id, categoria ) VALUES (null, '$category') ");
               $save->execute();

           }
        } catch(Exception $error) {
          throw new Exception($error->getMessage() . '/Error saving data');
        }
    }

    public function insertProduct($month, $id, $product, $quanty) 
    {
        try {
             $save = $this->connection->prepare(" 
                INSERT INTO produtos (id, mes_compra, categoria_id, produto, quantidade) 
                      VALUES (null, '$month', '$id', '$product', '$quanty') ");
             $save->execute();          
         } catch(Exception $error) {
           throw new Exception($error->getMessage() . '/Error saving data');
         }
    }

    public function rowCount($categorie) 
    {   
        $query =  $this->connection->prepare("SELECT categoria 
           FROM categorias WHERE categoria = :category ");

        $data = array(':category' => $categorie);
        
        $query->execute($data);
        $result = $query->rowCount();

        if ($result > 0) {
            return false;
        }
        return true;
    }
}