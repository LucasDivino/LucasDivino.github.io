<?php
	
	require 'PHPMailer/Exception.php';
	require 'PHPMailer/OAuth.php';
	require 'PHPMailer/PHPMailer.php';
	require 'PHPMailer/POP3.php';
	require 'PHPMailer/SMTP.php';


	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	print_r($_POST);

	class Mensagem {
		private $email = null;
		private $nome = null;
		private $mensagem = null;
		public $status = array( 'codigo_status' => null, 'descricao_status' => '');

		public function __get($atributo) {
			return $this->$atributo;
		}

		public function __set($atributo, $valor) {
			$this->$atributo = $valor;
		}

		public function mensagemValida() {
			if(empty($this->email) || empty($this->nome) || empty($this->mensagem)) {
				return false;
			}

			return true;
		}
	}

	$mensagem = new Mensagem();

	$mensagem->__set('email', $_POST['emailCliente']);
	$mensagem->__set('mensagem', $_POST['mensagemCliente']);
	$mensagem->__set('nome', $_POST['nomeCliente']);

	if(!$mensagem->mensagemValida()) {
		header('Location: index.php');
	}

	$emailEnviado = 0;

	$mail = new PHPMailer(true);
	try {
	    //Server settings
	    $mail->SMTPDebug = false;                            
	    $mail->isSMTP();                                      
	    $mail->Host = 'smtp.gmail.com';  					  
	    $mail->SMTPAuth = true;                               
	    $mail->Username = 'equipeb4u@gmail.com';           
	    $mail->Password = 'B4Utheteam';                         
	    $mail->SMTPSecure = 'tls';                           
	    $mail->Port = 587;                                   

	    //Recipients
	    $mail->setFrom('equipeb4u@gmail.com', 'Equipe B4U'); //remetente
	    $mail->addAddress($mensagem->__get('email'));     //  destinatário
	    $mail->addReplyTo('b4ucomercial@gmail.com', 'Information');  //resposta do destinatário
	   
	    $mail->isHTML(true);                                  // Set email 
	    $mail->Subject ='Resposta B4U';
	    $mail->Body    = 'Olá! <br> Texto generico para indicar para o cliente que recebemos a mensagem dele e agr ele pode se sentir avontade para deixar agt rico';

	    $mail->send();
	
	} catch (Exception $e) {
		
	}

	$emailEnviado++;

	try {
	    //Server settings
	    $mail->SMTPDebug = false;                            
	    $mail->isSMTP();                                      
	    $mail->Host = 'smtp.gmail.com';  					  
	    $mail->SMTPAuth = true;                               
	    $mail->Username = 'equipeb4u@gmail.com';           
	    $mail->Password = 'B4Utheteam';                         
	    $mail->SMTPSecure = 'tls';                           
	    $mail->Port = 587;                                   

	    //Recipients
	    $mail->setFrom('equipeb4u@gmail.com', 'cliente'); //remetente
	    $mail->addAddress('b4ucomercial@gmail.com');     //  destinatário
	    $mail->addReplyTo('b4ucomercial@gmail.com', 'Information');  //resposta do destinatário
	   
	    $mail->isHTML(true);                                  // Set email 
	    $mail->Subject = $mensagem->__get('Mensagem de:'+$mensagem->__get('nome'));

	    $mail->Body    = $mensagem->__get($mensagem->__get('email')+'<br>'+$mensagem->__get('nome')+'<br>'+$mensagem->__get('mensagem'));

	    $mail->send();

	    $mensagem->status['codigo_status'] = 1;
	    $mensagem->status['descricao_status'] = 'Sucesso!';
	
	} catch (Exception $e) {
		
	}

	$emailEnviado++;

?>