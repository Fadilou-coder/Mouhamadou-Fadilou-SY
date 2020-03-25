<?php
include('function.php');
session_start();
?>

<html>
    <head>
    <link href="exercice.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <center><br/><h1>Saisir un entier: </h1>
            <form action="" method="POST">
                <input type="text" name="n" value="<?php if (!empty($_SESSION['n'])) echo $_SESSION['n']; ?>" />
                <input type="submit" name="valider" />
            </form>
        </center>
    </body>
</html>

<?php


    if(isset($_POST['valider'])){
        
        $elmt = 100;
        $_SESSION['n'] = $_POST['n'];
        $_SESSION['bouton'] = $_POST['valider'];
        header('location: Exercice1.php?page=1');
    }
    if(isset($_SESSION['bouton'])){
        if(!empty($_SESSION['n'])){
            if (!(preg_match("#[^0-9]+# ", $_SESSION['n'])) and $_SESSION['n']>1000) {
                $T1 = array();
                $indice=0;
                $inf = array();
                $sup = array();
                
                
                for ($i=2; $i <= $_SESSION['n'] ; $i++) { 
                    if (premier($i)==1) {
                        $T1[$indice]=$i;
                        $indice++;
                    }
                }
                for ($i=0; $i < compte($T1) ; $i++) { 
                    if($T1[$i]>moyenne($T1)){
                        $sup[] = $T1[$i]; 
                    }
                    else{
                        if ($T1[$i]<moyenne($T1)) {
                            $inf[] = $T1[$i];
                        }
                    }
                }

                $T = array('inferieur' => $inf,
                           'superieur' => $sup);

                $ligne=10;
                $col = 10;
                $ind = 0;
?>
<?php

$page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
if(compte($inf)>compte($sup)){
    $total = compte($inf); //total items in array   
}
else{
    $total = compte($sup); //total items in array   
}
 
$limit = 100; //per page    
$totalPages = ceil( $total/ $limit ); //calculate total pages
$page = max($page, 1); //get 1 page when $_GET['page'] <= 0
$page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
$star = ($page - 1) * $limit;
if( $star < 0 ) $star = 0;

$_SESSION['inf'] = $inf;
$_SESSION['sup'] = $sup;


$_SESSION['inf'] = array_slice( $_SESSION['inf'], $star, $limit );
$_SESSION['sup'] = array_slice( $_SESSION['sup'], $star, $limit );

?>
            <center>
                <div style="height: 350px">
                
            <div style="width: 50%; float: left">
                <h4>Tableau des nombres inférieur à la moyenne(<?php echo moyenne($T1)?>).</h4>
                <table>
                <?php  for ($i=1; $i<= $ligne ; $i++) { 
                ?>
                               
                    <tr style = "<?php echo couleurtr($i)?>">
                           <?php 
                               for ($a=1; $a <= $col ; $a++) { 
                                   
                           ?>
                                       <td><?php if($ind < compte($_SESSION['inf'])){ echo $_SESSION['inf'][$ind++];} ?></td>
                                   
                           <?php 
                               }
                           ?>
                    </tr>
                           <?php  
                                   
                           }
                           $ind = 0;
                           
                           ?>
                </table>
            </div>
            <div style="width: 50%; float: left">
                <h4>Tableau des nombres supérieur à la moyenne(<?php echo moyenne($T1)?>).</h4>
                <table>
                <?php  for ($i=1; $i<= $ligne ; $i++) { 
                ?>
                               
                    <tr style = "<?php echo couleurtr($i)?>">
                           <?php 
                               for ($a=1; $a <= $col ; $a++) { 
                                   
                           ?>
                                       <td><?php if($ind < compte($_SESSION['sup'])){ echo $_SESSION['sup'][$ind++];} ?></td>
                                   
                           <?php 
                               }
                           ?>
                    </tr>
                           <?php  
                                   
                           }
                           
                           ?>
                </table>
            </div>
            </div>
<?php

$link = 'Exercice1.php?page=%d';
$pagerContainer = '<div>';   
if( $totalPages != 0 ) 
{
  if( $page == 1 ) 
  { 
    $pagerContainer .= ''; 
  } 
  else 
  { 
    $pagerContainer .= sprintf( '<a href="' . $link . '" style="color: #c00"> &#171; précedent</a>', $page - 1 ); 
  }
  $pagerContainer .= ' <span> page <strong>' . $page . '</strong> Sur ' . $totalPages . '</span>'; 
  if( $page == $totalPages ) 
  { 
    $pagerContainer .= ''; 
  }
  else 
  { 
     $_POST['valider']=true;
    $pagerContainer .= sprintf( '<a href="' . $link . '" style="color: #c00" > suivant &#187; </a>', $page + 1 ); 

  }           
}                   
$pagerContainer .= '</div>';

echo $pagerContainer;
                                                              
                               
                             

            }
            else{
                echo "saisir un entier supérieur à 10 000";
            }
        }
        else{
            echo "Remplir le champs";
        }
    }

?>
</center>