<?php
function displayAll(){
  try {
      $pdo = new PDO('sqlite:database.sqlite');
      // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $sql = "SELECT paths FROM TravelImage";
      $name = "Paths";
      $result = $pdo->query($sql);
      while ($row = $result->fetch()){
        outputSingleImage($row, $name);
      }
 
      $pdo = null;
   }
   catch (PDOException $e) {
      die( $e->getMessage() );
   }
}
function displayImages(){
   try {
      $pdo = new PDO('sqlite:database.sqlite');
      // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $sql = "SELECT paths FROM TravelImage INNER JOIN TravelImageDetails ON TravelImage.ImageID = TravelImageDetails.ImageID WHERE TravelImageDetails.CountryCodeISO ='". $_GET['country']. "'OR TravelImageDetails.CityCode ='" .$_GET['city'] . "'";
      $name = "Paths";
      $result = $pdo->query($sql);
      while ($row = $result->fetch()){
        outputSingleImage($row, $name);
      }
 
      $pdo = null;
   }
   catch (PDOException $e) {
      die( $e->getMessage() );
   }
}
function outputSingleImage($row, $name){
  echo "<div class='col-md-3' style='padding-bottom: 5px;'><img src='images/travel/square/" . $row[$name] . "'></div>"; 
}
function outputCountryOptions(){
  try {
      $pdo = new PDO('sqlite:database.sqlite');
      // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $sql = 'SELECT CountryName, ISO FROM (GeoCountries INNER JOIN TravelImageDetails ON GeoCountries.ISO = TravelImageDetails.CountryCodeISO) GROUP BY CountryName';
      $name = "CountryName";
      $code = "ISO";
      $result = $pdo->query($sql);
      while ($row = $result->fetch()){
        outputSingleOption($row, $name, $code);
      }
 
      $pdo = null;
   }
   catch (PDOException $e) {
      die( $e->getMessage() );
   }
}
function outputCityOptions(){
    try{
      $pdo = new PDO('sqlite:database.sqlite');
      
      $sql = 'SELECT AsciiName, GeoNameID FROM (GeoCities INNER JOIN TravelImageDetails ON GeoCities.GeoNameID = TravelImageDetails.CityCode) GROUP BY AsciiName';
      $name = "AsciiName";
      $code = "GeoNameID";
      $result = $pdo->query($sql);
      while ($row = $result->fetch()){
        outputSingleOption($row, $name, $code);
      }
 
      $pdo = null;
   }
   catch (PDOException $e) {
      die( $e->getMessage() );
   }
}
function outputSingleOption($row,$name, $code){
  echo "<option value= '". $row[$code] . "'>" . $row[$name] . "</option>";
}
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>Travel Template</title>
   <?php include 'includes/travel-head.inc.php'; ?>
</head>
<body>

  <?php include 'includes/travel-header.inc.php'; ?>
   
<div class="container">  <!-- start main content container -->
   <div class="row">  <!-- start main content row -->
      <div class="col-md-3">  <!-- start left navigation rail column -->
         <?php include 'includes/travel-left-rail.inc.php'; ?>
      </div>  <!-- end left navigation rail --> 
      
      <div class="col-md-9">  <!-- start main content column -->
         <ol class="breadcrumb">
           <li><a href="#">Home</a></li>
           <li><a href="#">Browse</a></li>
           <li class="active">Images</li>
         </ol>          
    
         <div class="well well-sm">
            <form class="form-inline" role="form" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <div class="form-group" >
                <select class="form-control" name="city">
                  <option value="0">Filter by City</option>
                    <?php outputCityOptions(); ?>
                </select>
              </div>
              <div class="form-group">
                <select class="form-control" name="country">
                  <option value="ZZZ">Filter by Country</option>
                  <?php outputCountryOptions(); ?>
                </select>
              </div>  
              <button type="submit" class="btn btn-primary">Filter</button>
            </form>         
         </div>      <!-- end filter well -->
         
         <div class="well">
            <div class="row">
                <?php
                if(isset($_GET['city']) || isset($_GET['country'])){ 
                displayImages(); 
                }
                else{
                  displayAll();
                }
                ?>
            </div>
         </div>   <!-- end images well -->

      </div>  <!-- end main content column -->
   </div>  <!-- end main content row -->
</div>   <!-- end main content container -->
   
<?php include 'includes/travel-footer.inc.php'; ?>   

   
   

 <script src="bootstrap3_travelTheme/assets/js/jquery.js"></script>
 <script src="bootstrap3_travelTheme/dist/js/bootstrap.min.js"></script>
 <script src="bootstrap3_travelTheme/assets/js/holder.js"></script>
</body>
</html>