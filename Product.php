<?php

require_once 'Save.php';

class Product  {
   public static $replaced;
   
   
   public static function run() 
   {   
      
      $items[] = include('lista-de-compras.php'); 
      $dataset = array();
      $dataset = Product::getOrderMonths($items);
      Product::createCSV( $dataset);       
   }

   /**
    *  Methods recebe a lista de produtos e gera um novo array ordenado por mês
    */

   public static function getOrderMonths(array $items) 
   {
       $monthsOfTheYear = ["janeiro", "fevereiro", "marco","abril","maio", "junho"];
       $maxSize = count($monthsOfTheYear);

       $sortedMonths = array();

       for($month = 0; $month < $maxSize; $month++ ) {
         foreach($items as  $item => $data) {
            foreach($data as $months => $product) {
              if ($monthsOfTheYear[$month] === $months) {
                  $sortedMonths[$months] = $product;
              }
            } 
         }
       }       
       return $sortedMonths;
   }

   public static function createCSV(array $data) 
   {
      $dataset = [];
      $file = fopen("compras-do-ano.csv", "w");
      fputcsv($file, ["Mes","Categoria","Produto","Quantidade"]);
    
      foreach($data as $month => $value) {  
         foreach($value as $category => $products) {           
            array_multisort($products, SORT_DESC, $products);
            foreach($products as $product => $totalProducts) {
               $product = Product::replaced($product);

               $save = new Save;
               $save->insertCategory($category);
               $categoryID = Product::getCategoryId($category);
               $save->insertProduct($month, $categoryID, $product, $totalProducts);
              
               $dataset = [$month, $category, $product, $totalProducts];
               fputcsv($file, $dataset);
            }          
         }
      }
      self::download();
      fclose($file);
   }

   /**
    * Recebe uma string, testa a igualdade com as chave do array, se for true $replaced recebe a string
    * substituída
    */
   public static function replaced($productName) 
   {
      self::$replaced = '';

      $replaces = array(
         'Papel Hignico' => 'Papel Higiênico',
         'Brocolis' => 'Brócolis',
         'Chocolate ao leit' => 'Chocolate ao leite',
         'Sabao em po' =>'Sabão em pó'
      );

      foreach($replaces as $key => $value) {
         if($productName === $key) {
            return self::$replaced = $value;
         }
      }
      return $productName;
   }

   public static function getCategoryId($category) 
   {  $categoryID = '';
      switch($category) {
        case 'alimentos':
           $categoryID = 1;
           break;
         case 'higiene_pessoal':
           $categoryID = 2;
           break;
         case 'limpeza':
           $categoryID = 3;
           break;
      }
      return $categoryID;
   }
   
   public static function download() 
   {
      header("Content-type: application/csv");   
      header("Content-Disposition: attachment; filename=file.csv");   
      header("Content-Transfer-Encoding: binary");
      header("Pragma: no-cache");
      readfile('compras-do-ano.csv' );
   } 

}

echo Product::run();

