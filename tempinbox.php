<?php

    session_start();
    $success = "";
    $error = "";
    $to = $_GET['to'];
    if (array_key_exists("id", $_COOKIE) && $_COOKIE ['id']) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        
    }

    if (array_key_exists("id", $_SESSION)) {
              
      $link = mysqli_connect("localhost", "root", "", "SocialZ");
        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }
        if (array_key_exists("submit-message", $_POST)) {
        
        $link = mysqli_connect("localhost", "root", "", "SocialZ");
        
            if (mysqli_connect_error()) {
            
                die ("Database Connection Error");
                
            }
          
            if(!$_POST['message'])
            {
                  $error = "<p>The message is empty!</p>";
                  
             }
            else
            {
              
              $query = "INSERT INTO messages(content,sender_id,receiver_id) VALUES ('".$_POST['message']."','".$_SESSION['id']."','".$_POST['submit-message']."')";
              $xx = $_POST['submit-message'];
                 if (!mysqli_query($link, $query)) 
                 {
                     $error = "<p>Please try again later.</p>";
                 }
                else
                {
                    $success = "<p>Posted successfully!</p>";
                    header("Location: tempinbox.php?to=$xx");
                    
                }
                     
            }
            
            
        }

    }  
        
    
else {
        
        header("Location: Login.php");
        
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <link href="bootstrap-5/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>
        <link href="StyleSheet.css" rel="stylesheet">
        <title>Inbox</title>
        <style>
            body{
                overflow-x: hidden;
            }
            /* width */
::-webkit-scrollbar {
  width: 10px;
    background-color: white;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #C2E9F2; 
  border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background:#75B7ED; 
}

@media screen and (min-width: 1024px)
{
  .card-style
  {
    height:33.8rem;word-wrap: break-word;
  }
  .inbox{

  overflow:hidden;background-color:#DAEDF2;height:28rem;border-radius:6px;padding:0.5rem
}
#message-container
  {
    min-height:24.5rem;max-height:24.5rem;overflow:scroll;overflow-x: hidden;
  }

  .email-container
  {
    height:24.5rem;overflow-x: hidden;
  }
}
@media screen and (min-width: 1152px)
{
  .card-style
  {
    height:41.5rem;word-wrap: break-word;
  }
  .inbox{

    overflow:hidden;background-color:#DAEDF2;height:35.5rem;border-radius:6px;padding:0.5rem
  }

  #message-container
  {
    min-height:31.5rem;max-height:31.5rem;overflow:scroll;overflow-x: hidden;
  }

  .email-container
  {
    height:31.5rem;overflow-x: hidden;
  }
}
        </style>
    </head>
    <body>
     <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #5DB0FF;">
             
    <div class="container-fluid">
    <div class="menuf">
      <a class="navbar-brand" href="#">
      <img src="img/logo1.png" alt="" class="logo" width="30" height="24">
    </a>
    <a class="navbar-brand" href="index.html">SocialOwl</a>
        </div>
       
   
      <div class="menu">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="search.php">Find People</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="home.php">Feed</a>
        </li>
          <li class="nav-item">
          <a class="nav-link " aria-current="page" href="MyProfile.php">My Profile</a>
        </li>
          <li class="nav-item">
          <a class="nav-link active" href="inbox.php">Inbox</a>
        </li>
          <li class="nav-item">
          <a class="nav-link " href="store.php">Store</a>
        </li>
          <li class="nav-item">
          <a href ='login.php?logout=1'>
        <button class="btn btn-success" type="submit" style="margin-left:0.5rem">Logout</button></a>
        </li>
      </ul>
      
    </div>
      </div>
  </div>
</nav>
      <div class="container" style="margin-top:4rem;margin-bottom:1rem">
        <div class="row">
            <div class="col-md-3" style="margin-left:-3%;margin-top:0.5rem">
    <div class="card">
      <div class="card-body card-style" style="overflow-y:scroll">
        <h4 class="card-title" style="color:darkblue">Your Connections</h4><hr>
        <?php
        
        include 'config.php';
        $query = "SELECT * from requests where to_id='".$_SESSION['id']."' or from_id='".$_SESSION['id']."'";
        $result = $db->query($query);
        if ($result->num_rows > 0 )
       {
          while ($row = $result->fetch_assoc()) 
          {
            if($row['flag']==1 )
            {
              if($row['from_id']==$_SESSION['id'] )
                $user = $row['to_id'];
              else
                $user = $row['from_id'];
              $q1 = "SELECT * from users where id='".$user."'";
              $res = $db->query($q1);
              if ($res->num_rows > 0 ) 
              {
                $x = "";
                while ($row1 = $res->fetch_assoc()) 
                {
                  if($row1['id']!= $_SESSION['id'])
                  {
                    echo "<a style='color:black' onclick='getsender(this.id)' id='".$row1['username']."' href='tempinbox.php?to=".$row1['id']."' name='text' value='".$row1['id']."'>".$row1['fname']." ".$row1['lname']."</a><hr>";
                  }
                }
              }
            }
          }
        }
      
        ?>
      </div>
    </div>
  </div>
  <div class="col-md" style="margin-left:1rem;margin-top:0.5rem;max-width:40%">
    <div class="card">
      <div class="card-body card-style" >
      <div style="color:darkblue;float:left">
          <h4 class="card-title" style="float:left">Inbox </h4>
          <div id="active-user" style="font-size: 20px;float:left;margin-left:0.2rem">
          <?php
              $query = "SELECT * from users where id = '".$to."'";
              $result = $link->query($query);
                if ($result->num_rows > 0 ) {
                    while ($row = $result->fetch_assoc()) {
                      echo " : ".$row['username'];
                    }
                  }
                  
          ?>
          </div>
        </div>
        <br><hr>
        <div class="inbox" >
        <?php
            echo
            '<div id="message-container" >';
            
             include 'config.php';
             $query = "Select * from messages where receiver_id = '".$_SESSION['id']."' or sender_id= '".$_SESSION['id']."'";
             $result = $link->query($query);
             if ($result->num_rows > 0 ) 
             {
               while ($row = $result->fetch_assoc()) 
               {
                 if($row['receiver_id']==$to)
                 {
                  echo '<div id="message-box" style="background-color:white;border-radius:2rem;padding:0.5rem 1rem;margin-top:1rem;word-wrap: break-word;margin-left:4rem;text-align:right;margin-right:0.5rem">';
                            echo $row['content']; 
                          echo '</div>';
                  
                      }
                 elseif($row['sender_id']==$to)
                 {
                  $query1 = "SELECT img FROM users WHERE id = '" .$to. "'";
                  $result1 = mysqli_query($link, $query1);
                  $row1 = mysqli_fetch_array($result1);
                  
                  echo '<div>';
                  echo '<img src="'.$row1['img'].'" style="height:2rem;border-radius:50%;float:left;"><div id="message-box" style="background-color:#5EA6D7;border-radius:2rem;padding:0.5rem 1rem;margin-top:1rem;word-wrap: break-word;margin-right:4rem;;margin-left:2.5rem">';
                  echo $row['content'];
                  echo '</div>';
                  echo '</div>';
                 }
               } 
              }
              else
              {
                echo '<div id="message-box" style="background-color:white;border-radius:2rem;padding:1rem;margin:1rem;word-wrap: break-word;margin: 8rem 4rem;text-align:center">';
                echo "Start a conversation!!";
                echo '</div>';
              }
           
            echo '</div>';
            ?>
            <div style="float:left;width:auto;margin-top:6px;">
            <form method="post">
            <div class="row">
                <div class="col-sm-9">
                    <input type="text"  id="message" name="message" class="form-control" placeholder="Type your message...">  
                </div>
                <div class="col-sm-2">
                    <?php echo '<button type="submit" name="submit-message" id="submit-message" class="btn " value="'.$to.'" style="margin-left:0.5rem;font-size:12px;float:left;margin-right:3rem">Send</button>';?>
               
                </div>
            </div> 
            </form>
          </div> 
          </div>
      </div>
    </div>
  </div>
  <div class="col-md" style="margin-right:-2rem;margin-left:1rem;margin-top:0.5rem">
    <div class="card">
        <div class="card-body card-style" >
        <div style="color:darkblue;float:left"><h4 class="card-title" style="float:left">Email </h4></div><br><hr>
        <div class="inbox" >
        <form method="post">
        <div class="email-container">
            <textarea class="form-control" placeholder="Subject" style="height:2.5rem;margin-bottom:7px"></textarea>
            <textarea class="form-control" placeholder="Enter the email body..." style="height:28.5rem"></textarea>   
        </div>
            <div style="float:left;width:auto;margin-top:6px;">
            <div class="row">
                <div class="col-md-8">
            <input type="file"  class="form-control" placeholder="Attach a file" multiple>  
                </div>
                <div class="col-md-2">
            <button type='submit' name='submit-comment' class='btn ' style='margin-left:0rem;font-size:12px;float:left;margin-right:0'>Send</button>
                </div>
                </div>
          </div>
         </form>
      </div>
    </div>
  </div>
</div>
            </div>
        </div>
        <script src="bootstrap-5/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script type="text/javascript">
           
             function getsender(id){
               
               document.getElementById('active-user').innerHTML = ":  "+id;
             
             }
</script>
    </body>
</html>