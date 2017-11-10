<?php 

   function displayGeo() {
  
   try {
      $pdo = new PDO('sqlite:database.sqlite');
      // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $sql = 'SELECT ContinentName FROM GeoContinents';
      $code ="0";
      $name = 'ContinentName';
      $result = $pdo->query($sql);
      while ($row = $result->fetch()){
        outputSingleRow($row, $name, $code);
      }
 
      $pdo = null;
   }
   catch (PDOException $e) {
      die( $e->getMessage() );
   }
}
  function outputSingleRow($row,$select, $code){
    echo "<div class='panel'><a href='?city=&country=" . $row[$code] ."'>" . $row[$select] . "</a></div>";
  } 
  function displayPopular(){
     try {
      $pdo = new PDO('sqlite:database.sqlite');
      // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $sql = 'SELECT CountryName, ISO FROM (GeoCountries INNER JOIN TravelImageDetails ON GeoCountries.ISO = TravelImageDetails.CountryCodeISO) GROUP BY CountryName';
      $name = "CountryName";
      $code = "ISO";
      $result = $pdo->query($sql);
      while ($row = $result->fetch()){
        outputSingleRow($row, $name, $code);
      }
 
      $pdo = null;
   }
   catch (PDOException $e) {
      die( $e->getMessage() );
   }
  }
?>

         <div class="panel panel-default">
           <div class="panel-heading">Search</div>
           <div class="panel-body">
             <form>
               <div class="input-group">
                  <input type="text" class="form-control" placeholder="search ...">
                  <span class="input-group-btn">
                    <button class="btn btn-warning" type="button"><span class="glyphicon glyphicon-search"></span>          
                    </button>
                  </span>
               </div>  
             </form>
           </div>
         </div>  <!-- end search panel -->       
      
         <div class="panel panel-info">
           <div class="panel-heading">Continents</div>
           <ul class="list-group">   
              <?php displayGeo(); ?>

           </ul>
         </div>  <!-- end continents panel -->  
         <div class="panel panel-info">
           <div class="panel-heading">Popular Countries</div>
           <ul class="list-group">  
           <?php displayPopular(); ?>
  
           </ul>
         </div>  <!-- end countries panel -->    