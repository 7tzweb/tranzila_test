<!DOCTYPE html>
<html lang="">
<?php

	//represh css and js by rand

	if($_SERVER['REMOTE_ADDR'] == '46.121.214.150'  ) {
		$rand ='?v='.rand(0,99999);
	}else{
		$rand = '?v='.'1';
	}
	$rand ='?v='.rand(0,99999);

	//baseurl
	$baseurl = $_SERVER['REQUEST_URI'];
	$v ='';
	if (strpos($baseurl, '&v=') !== false) {
		$arr_url = explode("&v=",$baseurl);
		$baseurl = $arr_url[0];
		//url get varable view
		if ($_GET['v']) {
			$v = $_GET['v'];
		}else{

		}
	}
	
?>
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Tsohar zigdon"/>
		<meta name="creator" content="Tsohar zigdon"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title><?php echo $title; ?></title>

		<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(STYLESHEET.'sweetalert.css'); ?>"> 
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(STYLESHEET.'main.css'.$rand); ?>">
	</head>
	<body>
		<div class="container-fluid">
			<div class="row" style="text-align: center;margin-top: 15px;">
				<h1>Task Management <small style="font-size: 12px;"> by <strong>Tsohar zigdon</strong></small></h1>
				<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10" style="float: none;display: inline-block;margin-top:20px;">
					<div id="input-panel">
						<form name="todo-form" id="todo-from">
							<input name="todo-input" placeholder="ADD TASK"/>
						</form>
					</div>
					<small id="log"></small>
					<div class="clearfix"></div>
					<hr/>
					<?php
					//check how much status 0
						$status0 = 0;
						foreach ($todos as $todo){
							if ($todo->status == 0){
								$status0++;
							}
						} 
					?>
					<div class="col-xs-12 col-sm-12 col-md-12" >
						<div class="col-xs-12 col-sm-12 col-md-4" >
							<a href="<?php echo $baseurl.'&v=t'; ?>" class="btn btn-primary">Total task &nbsp<span class="badge" id="task_t"><?php echo count($todos); ?></span></a>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4" >
							<a href="<?php echo $baseurl.'&v=c'; ?>" class="btn btn-primary">Task complete &nbsp<span class="badge" id="task_c"><?php echo count($todos) - $status0; ?></span></a>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4" >
							<a href="<?php echo $baseurl.'&v=r'; ?>" class="btn btn-primary">Task remaining &nbsp<span class="badge" id="task_r"><?php echo $status0; ?></span></a>
						</div>
					</div>
					<div class="clearfix"></div>

					<hr/>
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table" id="todo-container" style="">
									<tr><th id="id_header">#</th><th id="name_header">Task Name</th><th id="date_header">Date</th><th >edit</th></tr>
									<?php if (count($todos) > 0){
										
									foreach ($todos as $todo){
										if ($v =='t') {
											$condition = '$todo->status >= 0';
										}elseif($v =='c'){
											$condition = '$todo->status == 1';
										}else{
											$condition = '$todo->status == 0';
										}
											if (eval("return $condition;")){
										?>
									

										<tr data-id="<?php echo $todo->id; ?>" class="status<?php echo $todo->status; ?>">
											<td><?php echo $todo->id; ?></td>
											<td data-task="<?php echo $todo->id; ?>"><?php echo $todo->name; ?></td>
											<td><?php echo $todo->created_at; ?></td>
											<td style="position: relative;">
												<div class="action">
													<button data-toggle="tooltip" data-title="delete" class="delete-btn" data-id="<?php echo $todo->id; ?>"><i class="glyphicon glyphicon-trash"></i></button>
													<button data-toggle="tooltip" data-title="Edit" class="edit-btn" data-id="<?php echo $todo->id; ?>"><i class="glyphicon glyphicon-pencil"></i></button>
													<button data-toggle="tooltip" data-title="Done" class="done-btn" data-id="<?php echo $todo->id; ?>"><i class="glyphicon glyphicon-ok"></i></button>
												</div>
											</td>
										</tr>
									<?php }} } ?> 
								</table>
							</div>
								<span id="nothing" style="<?php echo (count($todos) > 0) ? 'display:none' : 'display:block'; ?>;color:#999">Nothind todo, add something..</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script type="text/javascript" src="<?php echo base_url(SCRIPT.'sweetalert.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url(SCRIPT.'jquery.sortElements.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url(SCRIPT.'main.js'.$rand); ?>"></script>
		

		
	</body>
</html>