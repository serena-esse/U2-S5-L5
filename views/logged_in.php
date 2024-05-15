<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="alert alert-light border" role="alert">
        Ciao <?php echo $_SESSION['user_name']; ?>. Sei loggato.
        Prova a chiudere questa scheda del browser e riaprirla. Rimani ancora loggato!
      </div>
    </div>
    <div class="col-md-4 mt-2">
      <button type="button" class="btn btn-dark"><a href="index.php?logout">Logout</a></button>
    </div>
  </div>
</div>
