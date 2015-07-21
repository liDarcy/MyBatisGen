<!DOCTYPE html>
<html lang="en">
	<head>
		<script src="public/js/jquery-1.8.2.min.js"></script>
		<script src="public/js/jquery-ui-1.9.2.custom.min.js"></script>
		
		<link rel="stylesheet" type="text/css" href="public/css/jquery-bootstrap-ui/jquery-ui-1.10.0.custom.css" />
	</head>
	
	<?php 
		require 'globals/include.php';
		$conn = Connection::getInstance();
		
		$users = $conn->query("SELECT * FROM users");
	?>
	
	<body>
		<form id="user-form">
			<table>
				<tr>
					<th>Profile Thumb</th>
					<th>Name</th>
					<th>Birthday</th>
					<th>Gender</th>
					<th>Department</th>
					<th>Class</th>
					<th></th>
				</tr>
				
				<?php foreach($users as $k => $data): ?>
					<tr>
						<td></td>
						<td class="name"><?php echo $data['name']; ?></td>
						<td class="birthday"><?php echo $data['birthday']; ?></td>
						<td class="gender"><?php echo $data['gender']; ?></td>
						<td class="department"><?php echo $data['department']; ?></td>
						<td class="class"><?php echo $data['class']; ?></td>
						<td>
							<a href="javascript:{};" class="delete" data-user-id="<?php echo $data['id']; ?>">Delete</a>
						</td>
					</tr>
				<?php endforeach; ?>
				
				<tr id="add-form-ajax">
					<td><input type="file" name="add[profile]" /></td>
					<td><input type="text" name="add[name]" /></td>
					<td><input type="text" name="add[birthday]" /></td>
					<td>
						<select name="add[gender]">
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
					</td>
					<td><input type="text" name="add[department]" /></td>
					<td><input type="text" name="add[class]" /></td>
					<td>
						<input type="button" id="add-btn" value="Add" />
					</td>
				</tr>
				
			</table>
			<div id="add-error-info"></div>
		</form>
	</body>
	
	<script>
		$(document).ready(function(){
			$('#user-form #add-btn').click(function(){
				$.ajax({
					type: 'post',
					url: 'ajaxProcessor.php?action=useradd',
					data: $('#user-form').serialize(),
					success: function(ret){
						$('#add-error-info').html('');
						if(!ret.result){
							$.each(ret.errors, function(k, v){
								$p = $('<p />');
								$p.text(k+': '+v);
								$('#add-error-info').append($p);
							});
						}else{
							$tr = $('<tr />');
							$tr.append($('<td />'));
							$tr.append($('<td />').text(ret.addPost.name));
							$tr.append($('<td />').text(ret.addPost.birthday));
							$tr.append($('<td />').text(ret.addPost.gender));
							$tr.append($('<td />').text(ret.addPost.department));
							$tr.append($('<td />').text(ret.addPost.class));
							//$tr.append($('<td />').html('<a href="javascript:{};" class="modify" data-user-id="'+ret.addPost.id+'">Modify</a>'));
							$tr.append($('<td />').html('<a href="javascript:{};" class="delete" data-user-id="'+ret.addPost.id+'">Delete</a>'));

							$('#add-form-ajax').before($tr);
						}
					},
					dataType: 'json'
				});
			});

			/*$('.delete').live('click', function(){
			$.ajax({
				type: 'post',
				url: 'ajaxProcessor.php?action=userdelete',
				data: $('#user-form').serialize(),
				success: function(ret){
					$('#delete-error-info').html('');
					if(!ret.result){
						$.each(ret.errors, function(k, v){
							$p = $('<p />');
							$p.text(k+':'+v);
							$('delete-error-info').append($p);
						});
					}
					else
					{
						$(this).parent().remove();
					}
					},
					dataType: 'json'
					)};
		});	*/		
		});
		
	</script>
</html>






















