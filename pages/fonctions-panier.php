<?php

/**
 * Verifie si le panier existe, le crée sinon
 * @return bool
 */
function creationPanier(){
   if (!isset($_SESSION['panier'])){
      $_SESSION['panier']=array();
      $_SESSION['panier']['libelleProduit'] = array();
      $_SESSION['panier']['qteProduit'] = array();
      $_SESSION['panier']['prixProduit'] = array();
      $_SESSION['panier']['verrou'] = false;
   }
   return true;
}



/**
 * Ajoute un article dans le panier
 * @param string $libelleProduit
 * @param float $prixProduit
 * @return void
 */
function ajouterArticle($libelleProduit,$prixProduit,$qteProduit = 1){

   //Si le panier existe
  
      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);


      if ($positionProduit !== false)
      {

         $_SESSION['panier']['qteProduit'][$positionProduit] += $qteProduit ;
      }
      else
      {

         //Sinon on ajoute le produit
         array_push( $_SESSION['panier']['libelleProduit'],$libelleProduit);
         array_push( $_SESSION['panier']['qteProduit'],$qteProduit);
         array_push( $_SESSION['panier']['prixProduit'],$prixProduit);

      }
   
}



/**
 * Modifie la quantité d'un article
 * @param $libelleProduit
 * @param $qteProduit
 * @return void
 */
function modifierQTeArticle($libelleProduit,$qteProduit){

      //Si la quantité est positive on modifie sinon on supprime l'article
      if ($qteProduit > 0)
      {
         //Recharche du produit dans le panier
         $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);

         if ($positionProduit !== false)
         {
            $_SESSION['panier']['qteProduit'][$positionProduit] = $qteProduit ;
         }
      }
      else
      supprimerArticle($libelleProduit);
   }

/**
 * Supprime un article du panier
 * @param $libelleProduit
 * @return 
 */
function supprimerArticle($libelleProduit){

   //Nous allons passer par un panier temporaire
   $tmp=array();
   $tmp['libelleProduit'] = array();
   $tmp['qteProduit'] = array();
   $tmp['prixProduit'] = array();

   if (isset($_SESSION['panier'])){
      for($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++)
   {
      if ($_SESSION['panier']['libelleProduit'][$i] !== $libelleProduit)
      {
         array_push( $tmp['libelleProduit'],$_SESSION['panier']['libelleProduit'][$i]);
         array_push( $tmp['qteProduit'],$_SESSION['panier']['qteProduit'][$i]);
         array_push( $tmp['prixProduit'],$_SESSION['panier']['prixProduit'][$i]);
      }

   }
   }
   else {
      echo("Le panier est vide");
   }
   
   //On remplace le panier en session par notre panier temporaire à jour
   $_SESSION['panier'] =  $tmp;
   //On efface notre panier temporaire
   unset($tmp);
   
}


/**
 * Montant total du panier
 * @return int
 */
function MontantGlobal(){
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++)
   {
      $total += $_SESSION['panier']['qteProduit'][$i] * (int)$_SESSION['panier']['prixProduit'][$i];
   }
   return $total;
}


/**
 * Fonction de suppression du panier
 * @return void
 */
function supprimePanier(){
   unset($_SESSION['panier']);
}

/**
 * Compte le nombre d'articles différents dans le panier
 * @return int
 */
function compterArticles()
{
   if (isset($_SESSION['panier']))
   return count($_SESSION['panier']['libelleProduit']);
   else
   return 0;

}

?>