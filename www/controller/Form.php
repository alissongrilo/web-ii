<?php
class Form
{
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/form.html");
    $retorno["msg"] = $form->saida();
    return $retorno;
  }

  public function salvar()
  {
    if (isset($_POST["titulo"]) && isset($_POST["autores"]) && isset($_POST["descricao"])) {
      try {
        $conexao = Transaction::get();
        $titulo = $conexao->quote($_POST["titulo"]);
        $autores = $conexao->quote($_POST["autores"]);
        $descricao = $conexao->quote($_POST["descricao"]);
        $crud = new Crud();
        $retorno = $crud->insert(
          "projetos",
          "titulo,autores,descricao",
          "{$titulo},{$autores},{$descricao}"
        );
      } catch (Exception $e) {
        $retorno["msg"] = "Ocorreu um erro! " . $e->getMessage();
        $retorno["erro"] = TRUE;
      }
    } else {
      $retorno["msg"] = "Preencha todos os campos! ";
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function __destruct()
  {
    Transaction::close();
  }
}
