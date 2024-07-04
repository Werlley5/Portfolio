<?php

    class funcoes
    {

        public static function generateSlug($str){
            $str = mb_strtolower($str);
            $str = preg_replace('/(â|á|ã)/','a',$str);
            $str = preg_replace('/(ê|é)/','e',$str);
            $str = preg_replace('/(í|i)/','i',$str);
            $str = preg_replace('/(ú)/','u',$str);
            $str = preg_replace('/(ó|ô|õ|Ô)/','o',$str);
            $str = preg_replace('/(_|\/|!|\?#)/','',$str);
            $str = preg_replace('/( )/','-',$str);
            $str = preg_replace('/ç/','c',$str);
            $str = preg_replace('/(-[-]{1,})/','-',$str);
            $str = preg_replace('/(,)/','-',$str);
            $str = strtolower($str);
            return $str;
        }
        
        public static function logado(){
            return isset($_SESSION['login']) ? true : false;
        }

        public static function loggout(){
            setcookie('lembra','true',time() - 1,'/');
            session_destroy();
            header('Location: '.INCLUDE_PATH_PAINEL);
        }

        public static function carregarPagina(){
            if(isset($_GET['url'])) {
                $url = explode('/', $_GET['url']);
                if(file_exists('pages/'.$url[0].'.php')) {
                    include('pages/'.$url[0].'.php');
                }else {
                    header('Location: '.INCLUDE_PATH_PAINEL);
                }
            }else {
                include('pages/home.php');
            }
        }

        public static function listarUsuariosOnline(){
            self::limparUsuariosOnline();
            $sql = mysql::conectar()->prepare("SELECT * FROM `tb_admin.online`");
            $sql->execute();
            return $sql->fetchAll();
        }

        public static function limparUsuariosOnline(){
            $date = date('Y-m-d H:i:s');
            $sql = mysql::conectar()->exec("DELETE FROM `tb_admin.online` WHERE ultima_acao < '$date' - INTERVAL 1 MINUTE");
        }

        public static function pegarVisitasTotais() {
           $sql = mysql::conectar()->prepare("SELECT * FROM `tb_admin.visitas`");
           $sql->execute();
           return $sql->rowCount();
        }

        public static function pegarVisitasHoje() {
            $sql = mysql::conectar()->prepare("SELECT * FROM `tb_admin.visitas` WHERE dia = ?");
            $sql->execute(array(date('Y-m-d')));
            return $sql->rowCount();
        }

        public static function alert($tipo,$mensagem) {
            if($tipo == 'sucesso') {
                echo '<div class="box-alert sucesso"><i class="fa fa-check"></i> '.$mensagem.'</div>';
            }else if($tipo == 'erro') {
                echo '<div class="box-alert erro"><i class="fa fa-close"></i> '.$mensagem.'</div>';
            }else if($tipo == 'atencao'){
                echo '<div class="box-alert atencao"><i class="fa fa-warning"></i> '.$mensagem.'</div>';
            }
        }

        public static function alertJs($mensagem){
            echo '<script>alert("'.$mensagem.'")</script>';
        }

        public static function imagemValida($imagem) {
            if($imagem['type'] == 'image/jpeg' || 
                $imagem['type'] == 'image/jpg' || 
                $imagem['type'] == 'image/png') {

                $tamanho = intval($imagem['size']/1024);
                if($tamanho < 900)
                    return true;
                else
                    return false;  
            }else{
                return false;
            }
        }

        public static function uploadFile($file) {
            $formatoArquivo = explode('.',$file['name']);
            $imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];
            if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL.'/uploads/'.$imagemNome))
                return $imagemNome;
            else
                return false;
        }

        public static function deleteFile($file) {
            @unlink('uploads/'.$file);
        }

        public static function insert($arr){
            $certo = true;
            $nome_tabela = $arr['nome_tabela'];
            $query = "INSERT INTO `$nome_tabela` VALUES (null";
            foreach($arr as $key => $value){
                $nome = $key;
                $valor = $value;
                if($nome == 'acao' || $nome == 'nome_tabela')
                    continue;
                if($value == ''){
                    $certo = false;
                    break;
                }
                $query.=",?";
                $parametros[] = $value;
            }
            $query.=")";
            if($certo == true){
                $sql = mysql::conectar()->prepare($query);
                $sql->execute($parametros);
                $lastId = mysql::conectar()->lastInsertId();
                $sql = mysql::conectar()->prepare("UPDATE `$nome_tabela` SET order_id = ? WHERE id = $lastId");
                $sql->execute(array($lastId));
            }
            return $certo;
        }

        public static function selectAll($tabela,$start = null,$end = null){
            if($start == null && $end == null)
                $sql = mysql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC");
            else
                $sql = mysql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC LIMIT $start,$end");
                
            $sql->execute();
            return $sql->fetchAll();
        }

        public static function deletar($tabela,$id=false){

            if($id == false){
                $sql = mysql::conectar()->prepare("DELETE FROM `$tabela`");
            }else{
                $sql = mysql::conectar()->prepare("DELETE FROM `$tabela` WHERE id = $id");
            }
            $sql->execute();
            
        }

        public static function redirect($url){
            echo '<script>location.href="'.$url.'"</script>';
            die();
        }

        public static function select($table,$query,$arr){
            $sql = mysql::conectar()->prepare("SELECT * FROM `$table` WHERE $query");
            $sql->execute($arr);
            return $sql->fetch();
        }

        public static function update($arr){
            $certo = true;
            $first = false;
            $nome_tabela = $arr['nome_tabela'];
            $query = "UPDATE `$nome_tabela` SET ";
            foreach($arr as $key => $value){
                $nome = $key;
                $valor = $value;
                if($nome == 'acao' || $nome == 'nome_tabela' || $nome == 'id')
                    continue;
                if($value == ''){
                    $certo = false;
                    break;
                }
                
                if($first == false){
                    $first = true;
                    $query.="$nome=?";
                }
                else{
                    $query.=",$nome=?";
                }

                $parametros[] = $value;
            }

            if($certo == true){
                $parametros[] = $arr['id'];
                $sql = mysql::conectar()->prepare($query.' WHERE id = ?');
                $sql->execute($parametros);
            }
            return $certo;
        }

        public static function orderItem($tabela,$orderType,$idItem){
            if($orderType == 'up'){
                $infoItemAtual = Painel::select($tabela,'id=?',array($idItem));
                $order_id = $infoItemAtual['order_id'];
                $itemBefore = mysql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id < $order_id ORDER BY order_id DESC LIMIT 1");
                $itemBefore->execute();
                if($itemBefore->rowCount() == 0)
                    return;
                $itemBefore = $itemBefore->fetch();
                Painel::update(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
                Painel::update(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));
            }else if($orderType == 'down'){
                $infoItemAtual = Painel::select($tabela,'id=?',array($idItem));
                $order_id = $infoItemAtual['order_id'];
                $itemBefore = mysql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id > $order_id ORDER BY order_id ASC LIMIT 1");
                $itemBefore->execute();
                if($itemBefore->rowCount() == 0)
                    return;
                $itemBefore = $itemBefore->fetch();
                Painel::update(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
                Painel::update(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));
            }
        }

        public static function verificaId($par){
            if(!isset($par)){
                self::alert('erro','Você precisa passar o parâmetro ID!');
                die();
            }
        }

        public static function loadJs($arq,$url){
            if(isset($_GET['url']) && $_GET['url'] == $url){
                echo '<script src="'.INCLUDE_PATH_PAINEL.'js/'.$arq.'"></script>';
            }
        }

        public static function valorFormatado($valor){
            $preco1 = str_replace('.', '', $valor);
            $preco2 = str_replace(',', '.', $preco1);
            return $preco2;
        }

        public static function convertMoney($valor){
            return number_format($valor,2,",",".");
        }

        // Funções recentes

        //funções do sistema de gestão de clientes
        public static function uploadClientes($file) {
            $formatoArquivo = explode('.',$file['name']);
            $imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];
            if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL.'/clientes_img/'.$imagemNome))
                return $imagemNome;
            else
                return false;
        }

        public static function deleteImgCliente($file) {
            @unlink('clientes_img/'.$file);
        }

        //funções do sistema de controle de estoque
        public static function uploadProdutos($file) {
            $formatoArquivo = explode('.',$file['name']);
            $imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];
            if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL.'/produtos_img/'.$imagemNome))
                return $imagemNome;
            else
                return false;
        }

        public static function deleteImgProdutos($file) {
            //@unlink(BASE_DIR_PAINEL.'/produtos_img/'.$file);
            @unlink('produtos_img/'.$file);
        }

        //funções do sistema de gestão de imaóveis
        public static function uploadImoveis($file) {
            $formatoArquivo = explode('.',$file['name']);
            $imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];
            if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL.'/imoveis_img/'.$imagemNome))
                return $imagemNome;
            else
                return false;
        }

        public static function deleteImgImoveis($file) {
            //@unlink(BASE_DIR_PAINEL.'/produtos_img/'.$file);
            @unlink('imoveis_img/'.$file);
        }
        
    }

?>