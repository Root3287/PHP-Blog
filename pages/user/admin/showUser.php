<?php
define("path","../../../");
$page = "Edit User";
include path.'inc/init.php';
$user = new User();
?>
<html>
	<head>
		<?php include path.'assets/php/css.php';?>
	</head>
	<body>
		<?php include path.'assets/php/nav.php';?>
		<div class="container">
			<table class="table table-striped table-hover">
				<thead>
    				<tr>
      					<th>#</th>
					    <th>Username</th>
					    <th>Name</th>
					    <th>Group ID</th>
					    <th>Joined</th>
					    <th>Edit</th>
					    <th>Delete</th>
    				</tr>
  				</thead>
  				<tbody>
    				<?php 
  					$allUser = $db->get("users", array('1','=','1'))->results();
  					foreach ($allUser as $users){
  						echo '<tr>';
  						echo '<td>';
  						echo $users->id;
						echo '</td>';
						echo '<td>';
						echo $users->username;
						echo '</td>';
						echo '<td>';
						echo $users->name;
						echo '</td>';
						echo '<td>';
						echo $users->group;
						echo '</td>';
						echo '<td>';
						echo $users->joined;
						echo '</td>';
						echo '<td>';
						echo '<a class="btn btn-info" href="editUser.php?uid='.$users->id.'">Edit</a>';
						echo '</td>';
						echo '<td>';
						echo '<a class="btn btn-danger" href="deleteUser.php?uid='.$users->id.'">Delete</a>';
						echo '</td>';
						echo '<tr>';
  					}
  					?>
  				</tbody>
			</table>
			</div>
		<?php include path.'assets/php/js.php';?>
	</body>
</html>