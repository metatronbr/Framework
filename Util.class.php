<?php
require_once("config.inc.php");

class Util extends Config{
	
	public function tiraAcento($string){
		$str = str_replace("Ã¡","a",$string);
		$str = str_replace("Ã¡","e",$str);
		$str = str_replace("Ã­","i",$str);
		$str = str_replace("Ã³","o",$str);
		$str = str_replace("Ãº","u",$str);
		$str = str_replace("Ã£","a",$str);
		$str = str_replace("Ãµ","o",$str);
		$str = str_replace("Ãª","e",$str);
		$str = str_replace("Ã´","o",$str);
		$str = str_replace("Ã§","c",$str);
		$str = str_replace("Ã�","A",$string);
		$str = str_replace("Ã‰","E",$str);
		$str = str_replace("Ã�","I",$str);
		$str = str_replace("Ã“","O",$str);
		$str = str_replace("Ãš","U",$str);
		$str = str_replace("Ãƒ","A",$str);
		$str = str_replace("Ã•","O",$str);
		$str = str_replace("ÃŠ","E",$str);
		$str = str_replace("Ã”","O",$str);
		$str = str_replace("Ã‡","C",$str);
		return $str;
	}
	public function truncateWords($input, $numwords, $padding=""){
		$output = strtok($input, " \n");
		while(--$numwords > 0) $output .= " " . strtok(" \n");
		if($output != $input) $output .= $padding;
		return $output;
	}
	public function addslash($dados){
		foreach ($dados as $nome => $valor){
			$dados[$nome] = addslashes($valor);
		}
		
		return $dados;
	}
	public function tiraP($string){
		$string = str_replace("<p>","",$string);
		$string = str_replace("</p>","",$string);
		return $string;
	}
	
	public function tiraP2($string){
		$content = $string;
		$content = str_replace('<em>',"<l>",$content);
		$content = str_replace('</em>',"</l>",$content);
		$content = str_replace('class="vt-p"',"",$content);
		$content = preg_replace('/<p[^>]*>/', '', $content); // Remove the start <p> or <p attr="">
		$content = preg_replace('/<\/p>/', '<br />', $content); // Replace the end
		return $content; // Output content without P tags
	}
	public function seguranca($dados){
		$_dd = array();
		while (list($key, $value) = each($dados)) {
			//echo "Key: $key; Value: $value<br />\n";
			
			if($key != "tags") $_dd[$key] = $this->limpaString($value);
			
		}
		
		return $_dd;
	}
	
	public function security($string){
		$string = $this->limpaString($string);
		$string = str_replace("'","",$string);
		$string = str_replace("\"","",$string);
		$string = addslashes($string);
		return $string;
	}
	
	public function limpaString($string){
		
		if(!is_array($string)){
			$str = htmlspecialchars($string, ENT_QUOTES);
		}
		return $str;
	}
	
	public function gerarSenha(){
		$CaracteresAceitos = 'abcdxywzABCDZYWZ0123456789'; 
		$max = strlen($CaracteresAceitos)-1;
		$password = null;
		for($i=0; $i < 8; $i++) { 
			$password .= $CaracteresAceitos{mt_rand(0, $max)}; 
		}
		return $password;
	}
	
	public function redirect($url,$msg = null,$classe = 'alert-success'){
		
		if ($url){
			if($msg) $url = $url."?msg=$msg"."&classe=".$classe;
			print "<script>location.href='$url';</script>";			
		}
	}
	
	public function deixaNumeros($string){
		
		$string = preg_replace("/[^0-9]/","", $string);
		return $string;
	
	}
	
	public function enviaEmail($to,$to_nome,$from,$from_nome,$mensagem,$tipo){
		
		$headers = "From: $from_nome <$from> \n";
		$headers .= "Content-Type: text/html; charset=iso-8859-1";
		
		if($tipo == "indicacao"){
			$subject = "Seu amigo $from_nome indicou uma oferta para você";
			$body = $mensagem;
		}else if($tipo == "contato"){
			$subject = "Contato pelo site";
			$body = $mensagem;
			
		}else if($tipo == "recupera"){
			$subject = "Pedido de recuperação de senha. Guelta.com.br";
			$body = $mensagem;
		}
		
		ini_set('sendmail_from', $this->emailPref);
		mail($to, $subject, $body, $headers);
		
		return;
		
		
	}
	
}
?>