<?php
require_once("pre.php");

class Email {
    public static function validar($email) {
       return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
    }

  	protected function enviar($destino,$assunto,$data,$template,$campos) {
  		global $db;
  		$data = array($destino,
                $template,
                $data,
                $assunto);
  		$q = "INSERT INTO enviarEmail(ee_usuario,ee_template,ee_programado,ee_assunto) ";
  		$q .="VALUES (?,?,?,?)";
  		$sth = $db->prepare($q);
  		if (PEAR::isError($sth)) {
		    error_log($sth->getMessage()." / ".$sth->getDebugInfo());
    		die($sth->getMessage());
  		}
  		$res =& $db->execute($sth, $data); // Insere os dados de envio de e-mail
  		if (PEAR::isError($res)) {
			error_log($res->getMessage()." / ".$res->getDebugInfo());
      		die($res->getMessage());
  		}
  		if (count($campos) > 0 ) {
      		$res = $db->getOne("SELECT LAST_INSERT_ID() FROM `enviarEmail`");
    		if (PEAR::isError($res)) {
			    error_log($res->getMessage()." / ".$res->getDebugInfo());
      			die($res->getMessage());
    		}
    		$id = $res;
    		$q = "INSERT INTO enviarEmailCampo VALUES ";
    		$ct=1;
    		foreach ($campos as $c){
      			if ($ct > 1)
            		$q .= ",";
      			$q .= "('$id','$ct','$c')";
      			$ct++;
    		}
    		$res =& $db->query($q);  // Insere os campos complementares dos e-mails
    		if (PEAR::isError($res)) {
				error_log($res->getMessage()." / ".$res->getDebugInfo());
    	  		die($res->getMessage());
    		}
		}
  	}

  	public function convidarNotorio($usuarioDestino) {
  		global $db;
		$res = $db->getAll("SELECT u.email email, u.senha senha FROM usuarios u WHERE u.idusu=?;",array($usuarioDestino),DB_FETCHMODE_ASSOC);
  		if (PEAR::isError($res)) {
	    	error_log($res->getMessage()." / ".$res->getDebugInfo());
    		die($res->getMessage());
  		}
		$this->enviar($usuarioDestino,
		              "Convite do BolCo 2014",
					  strftime("%Y-%m-%d %H:%M:%S"),
					  "emailConvite1",
					  array($res[0]["email"],$res[0]["senha"]));
  	}

  	public function convidarConhecido($usuarioDestino,$comentario) {
	    global $db;
		$res = $db->getAll("SELECT n.nome nome, u.email email, u.senha senha FROM usuarios u, usuarios n WHERE u.quemchamou=n.idusu and u.idusu=?;",array($usuarioDestino),DB_FETCHMODE_ASSOC);
  		if (PEAR::isError($res)) {
	    	error_log($res->getMessage()." / ".$res->getDebugInfo());
    		die($res->getMessage());
  		}
  		$this->enviar($usuarioDestino,
					  "Convite do BolCo 2014",
					  strftime("%Y-%m-%d %H:%M:%S"),
					  "emailConvite2",
					  array($res[0]["nome"],$res[0]["email"],$res[0]["senha"],$comentario));
  	}

  	public function enviarSenha($emailDestino) {
	    global $db;
			$res = $db->getAll("SELECT idusu ,apelido, email, senha  FROM usuarios WHERE email=?;",array(strtolower($emailDestino)),DB_FETCHMODE_ASSOC);
  		if (PEAR::isError($res)) {
	    	error_log($res->getMessage()." / ".$res->getDebugInfo());
    		die($res->getMessage());
  		}
  		if ($res) {
  				$this->enviar($res[0]["idusu"],
					  "Lembrete de Senha",
					  strftime("%Y-%m-%d %H:%M:%S"),
					  "esqueciSenha",
					  array($res[0]["apelido"],$res[0]["email"],$res[0]["senha"],$_SERVER["REMOTE_ADDR"]));
			  return true;
			}else {
				return false;
			}
  	}
}


?>
