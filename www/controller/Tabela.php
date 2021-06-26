<?php
class Tabela
{
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    try {
      Transaction::get();
      $crud = new Crud();
      $retorno = $crud->select("projetos");
      if (!$retorno["erro"]) {
        $tabela = new Template("view/tabela.html");
        $tabela->set("linha", $retorno["msg"]);
        $retorno["msg"] = $tabela->saida();
      }
    } catch (Exception $e) {
      $retorno["msg"] = "Ocorreu um erro! " . $e->getMessage();
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function remover()
  {
    if ($_GET["id"]) {
      try {
        $conexao = Transaction::get();
        $id = $conexao->quote($_GET["id"]);
        $crud = new Crud();
        $retorno = $crud->delete(
          "projetos",
          "id={$id}"
        );
      } catch (Exception $e) {
        $retorno["msg"] = "Ocorreu um erro! " . $e->getMessage();
        $retorno["erro"] = TRUE;
      }
    } else {
      $retorno["msg"] = "Faltando parâmetro! ";
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function __destruct()
  {
    Transaction::close();
  }
}
