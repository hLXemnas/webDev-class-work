<?php
session_start();

// initialize variables
$valid = false;
$email = "";
$password = "";
$emailMessage = 'Email is invalid';
if($_SERVER['REQUEST_METHOD'] == 'POST')
  $emailClass = 'error';
$passwordMessage = "Password is invalid";
if($_SERVER['REQUEST_METHOD'] == 'POST')
  $passwordClass = 'error';      


if($_SERVER["REQUEST_METHOD"] == "POST" || isset($_SESSION['email'])){
  if(isset($_SESSION['email']))
    $email = $_SESSION['email'];
  else{
    $email = $_POST['email'];
  }
  if(isset($_SESSION['password']))
    $password = $_SESSION['password'];
  else{
    $password = $_POST['password'];
  }
  $pdo = new PDO('sqlite:database.sqlite');
  $sql = "SELECT UserID from Credentials WHERE Username = '$email' AND Password = '$password'";
  $result = $pdo->query($sql);
  if($result->fetchColumn() > 0){
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    echo "<!DOCTYPE html>";
    echo "<html lang='en'><html>";
    echo "<h1>Welcome valid user</h1></br>";
    echo "<a href='logout.php'>Logout</a>";
    echo "</html>";
    $valid = true;
  }
}  


if($valid != true){
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Chapter 13</title>

   <!-- Bootstrap core CSS -->
   <link href="bootstrap3_defaultTheme/dist/css/bootstrap.css" rel="stylesheet">

   <!-- Custom styles for this template -->
   <link href="chapter13-project01.css" rel="stylesheet">


</head>

<body>

<div class="container">
   <div class="row">
      <div class="col-md-3">
      </div>
      <div class="col-md-6">
         <div id="login">

            <div class="page-header">
               <h2>Login</h2> 
            </div>
            <form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
              <div class="form-group <?php echo $emailClass; ?>">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="<?php $email; ?>" value="<?php echo $email; ?>">
                <p class="help-block <?php echo $emailClass; ?>"><?php if($_SERVER['REQUEST_METHOD']== 'POST'){ echo $emailMessage;} ?></p>
              </div>
              <div class="form-group <?php echo $passwordClass; ?>">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" name="password"  value="">
                <p class="help-block <?php echo $passwordClass ?>"><?php if($_SERVER['REQUEST_METHOD']== 'POST'){ echo $passwordMessage; }?></p>
              </div>
              <div class="form-group">
                <label for="exampleInputFile">Server</label>
                <select name="server" class="form-control">
                <?php
                  for ($i = 1; $i < 6; $i++) {
                     echo '<option>Server ' . $i . '</option>';
                  }
                ?>
                </select>             
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>  

         </div>
      </div>
      <div class="col-md-3">
      </div>
   </div>  
</div>  <!-- end container -->

 <script src="bootstrap3_defaultTheme/assets/js/jquery.js"></script>
 <script src="bootstrap3_defaultTheme/dist/js/bootstrap.min.js"></script>    
</body>
</html>
<?php  
  
}
?>
