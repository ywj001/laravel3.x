<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>MinCMS Install</title>
     <!-- Le styles -->
    <link href="../misc/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style> 
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]--> 
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">MinCMS Install</a>
           
        </div>
      </div>
    </div> 
    <div class="container">
		<h1>MinCMS Install</h1>
		<?php if($step==2){?>
       	<table width="100%" class='table table-striped table-bordered table-condensed'>
			<tbody>
			<?php 
			$error = false;
			foreach($test as $v){
			  if($v['write']!=1) $error = true;
			  ?>
			  <tr class="<?php if($v['write']==1){echo 'ok';}else{ echo 'error';};?>">
			    <th>
			      <?php echo $v['file'];?>  
			      <?php if($v['code']){ if($v['write']!=1){?>  
				     <p>  
				        <code> 
				          <?php foreach($v['code'] as $c){echo $c.'<br>';}?> 
				        </code> 
				    </p>
				 <?php }}?>  
			    </th>
			    <td><?php if($v['write']==1){echo '<i class="icon-ok"></i>';}else{echo '<i class="icon-remove"  ></i>';};?></td> 
			  </tr> 
			<?php }?> 
			</tbody>
			</table>
		 
			<a href="?step=3">	<button type="button" class="btn btn-primary">Next Step</button></a>
    </div> <!-- /container -->

    <?php }else if($step==3){?>
   <form method='POST'>
<?php if($error){?>
	   <div class='label label-warning'> 
	   	<?php echo $error; ?>
	   </div>
	  <?php } ?>
<label>MySQL host</label><input name='host' value='localhost'> <br>
<label>MySQL username</label><input name='user' value="<?php echo $username;?>"><br>
<label>MySQL password</label><input name='pwd' value="<?php echo $password;?>"><br>
<label>MySQL database</label><input name='database' value="<?php echo $database;?>"><br>
<input type='hidden' name='step' value=3> 
<p></p>
<input type="submit" class='btn btn-info' value="Install" >
</form>    	 
	
		<?php }else if($step==5){?>
	
	<div class="alert alert-success">  
	  <strong>IThe installation was successful</strong> 
	   <p>Remove <code>public/install</code></p>
	   <p>If you needn't reinstall please remove </p>
	   <p><code>application/config/database_install.php</code></p>
	   <p> <code>application/config/database_default.php</code></p>
	   <p>If you want reinstall please change <code>application/config/database_install.php</code> to <code>application/config/database.php</code></p>
	    
	</div>
	<?php }?>	
	
  </body>
</html>
