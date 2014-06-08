<?php

require_once("pre.php");

class Usuario {
  public $id;
  public $apelido;
  public $nome;
  public $email;
  public $telefone;
  
  protected function criarSenha() {
      return rand(1000, 9999);
  }
    
  public static function emailExiste($email) {
    global $db;
	return intval($db->getOne('SELECT idusu FROM usuarios WHERE email = ?',strtolower($email)));
  }
  
   public function aceitarRegulamento() {
    global $db;
	$db->query('UPDATE usuarios SET aceitaReg=0 WHERE idusu = ?', $this->idusu);
	$_SESSION["Aceitou"] = 0;
  }
  
  public static function apelidoExiste($apelido) {
    global $db;
	return intval($db->getOne('SELECT idusu FROM usuarios WHERE apelido = ?',$apelido));
  }

  public function __construct($id) {
    global $db;
	$res =& $db->query('SELECT * FROM usuarios WHERE idusu = ?',$id);
	if ($res->fetchInto($row,DB_FETCHMODE_ASSOC)) {
	  $this->idusu = $row['idusu'];
	  $this->apelido = $row['apelido'];
	  $this->nome = $row['nome'];
	  $this->email = $row['email'];
	  $this->aceitouReg = $row['aceitouReg']?$row['aceitouReg']:1;
	  return true;
	} else {
	  return false;
    }
  }

  public function alterar($apelido,$nome,$telefone,$senha){
    global $db;
    if((strlen($apelido) > 0) && ($apelido != $this->apelido)) {
	  if (!self::apelidoExiste($apelido)) {
	    $update[]='apelido=?';
	    $data[]=$apelido;
	  }
	}
    if((strlen($nome) > 0) && ($nome != $this->nome)) {
	  $update[]='nome=?';
	  $data[]=$nome;
	}
    if((strlen($telefone) > 0) && ($telefone != $this->telefone)) {
	  $update[]='telefone=?';
	  $data[]=$telefone;
	}
    if((strlen($senha) > 0) && ($senha != $this->senha)) {
	  $update[]='senha=?';
	  $data[]=$senha;
	}
    if (count($update) > 0) {
	  $sql='UPDATE usuarios SET ' . implode(',',$update) . ' WHERE idusu=?';
	  $data[]=$this->id;
	  $res =& $db->query($sql);
	}
  }
}

class ConviteUsuario extends Usuario {
	public function __construct($email,$tipo,$idConvidador) {
    	global $db;
		$this->senha = $this->criarSenha();
	 	$this->email = strtolower($email);
		$parts = explode("@", $this->email);
		$this->apelido = $parts[0];
     	$q = "INSERT INTO usuarios (apelido, senha, dateCreated, pago, tipo, email, ativo, quemchamou, aceitouReg) VALUES (?,CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00'),?,?,?,?,?,?)";
	 	$res = $db->query($q,array($this->apelido, $this->senha,0,$tipo,$this->email,0,intval($idConvidador),1));
	 	if (PEAR::isError($res)) {
			error_log($res->getMessage()." / ".$res->getDebugInfo());
  	    	die($res->getMessage());
	 	} 
	 	$this->id = $db->getOne("SELECT LAST_INSERT_ID() FROM `enviarEmail`");  
    	if (PEAR::isError($res)) {
			error_log($res->getMessage()." / ".$res->getDebugInfo());
      		die($res->getMessage());
    	}
		$q = "INSERT INTO logbolco (lo_tipo, lo_usuario, lo_desc, lo_data) VALUES (?,?,?,CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00'))";  
    	$res = $db->query($q,array('Envio de convite',$idConvidador,'Envio de convite para $email'));
    	if (PEAR::isError($res)) {
			error_log($res->getMessage()." / ".$res->getDebugInfo());
      		die($res->getMessage());
    	}
	}
}

?>