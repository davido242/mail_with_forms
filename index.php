<!-- the new video for sending mail algorithm -->
<?php

	$error = '';
	$name = '';
	$email = '';
	$subject = '';
	$message = '';

	function clean_text($string){
		$string = trim($string);
		$string = stripslashes($string);
		$string = htmlspecialchars($string);
		return $string;

	}
	if(isset($_POST['submit'])){
		if (empty($_POST["name"]))
		{
			$error .= '<p>Enter your Name</p>';
		}
		else{
			$name = clean_text($_POST["name"]);
			if(!preg_match("/^[a-zA-Z ]*$/",$name))
			{
				$error .= '<p>Only letters and White Spaces allowed</p>';
			}
		}
		if(empty($_POST["email"])){
			$error .= '<p>Enter your Email</p>';
		}
		else{
			$email = clean_text($_POST["email"]);
			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$error.= '<p>Invalid Email Format</p>';
			}
		}
		if(empty($_POST["subject"])){
			$error .= '<p>Subject is Required</p>';
		}
		else{
			$subject = clean_text($_POST["subject"]);
		}
		if(empty($_POST["message"])){
			$error .= '<p>Message is Required</p>';
		}
		else{
			$message = clean_text($_POST["message"]);
		}
		if($error != ''){
			require 'PHPMailerAutoload.php';
			$mail = new PHPMailer;
			$mail -> isSMTP();
			$mail ->Host = 'smtp.gmail.com';
			$mail ->Port = '587';
			$mail ->SMTPAuth = true;
			$mail ->Username = 'davidsarka242@gmail.com';
			$mail ->Password = 'my password';
			$mail ->SMTPSecure = '';
			$mail ->From = ('davidsarka242@gmail.com, OnlineMD Dev World');
			$mail ->FromName = $_POST["name"];
			$mail ->addAddress($_POST["email"]);
			$mail ->WordWrap = 50;
			$mail ->IsHTML(true);
			$mail ->Subject = $_POST["subject"];
			$mail ->Body = $_POST["message"];
			if(!$mail->Send()){
					echo '<h2 style="color: red; text-align:center; margin-top: 50px;">Error in Sending Mail, Recheck!</h2>';
			}
				else{
					echo '<h2 style="width: 400px; color: green; text-align:center; background:#fff; margin: 50px 550px;">Thanks for contacting OnlineMD</h2>';
				}
				$name = '';
				$email = '';
				$subject = '';
				$message = '';
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>My first Email on Localn Host</title>
	<style type="text/css">
	*{
	padding: 0;
	margin: 0;
	}
	body{
	background: navy;
	color: #fff;
	font-family: sans-serif;
	}
	.form_cont{
		display: block;
		margin: 10px 80px;
		width: 70%;
		outline: none;
		padding: 5px 10px;
	}
.form_cont:focus{
		outline: 2px solid blue;
	}
	div{
		width: 40%;
		height: auto;
		line-height: 1.5em;
		background: #08072f;
		margin: 70px 30%;
		text-align: center;
		border-radius: 20px;
		padding: 20px 50px;
	}
	textarea{
		height: 80px;
	}

</style>
</head>
<body>
	<div>
		<h2>Send us a Mail!</h2>
		<?php echo $error; ?>
		<form method="post">
			<input type="text" name="name" class="form_cont" placeholder="enter your name" 
			value="<?php echo $name; ?>" />
			<input type="email" name="email" class="form_cont" placeholder="enter email" 
			value="<?php echo $email; ?>" />
			<input type="text" name="subject" class="form_cont" placeholder="enter subject" 
			value="<?php echo $subject; ?>" />
			<textarea name="message" class="form_cont" placeholder="Enter your message">
				<?php echo $message; ?>
			</textarea>
			<input type="submit" name="submit" value="submit">
		</form>
	</div>
<!-- https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting -->
</body>
</html>