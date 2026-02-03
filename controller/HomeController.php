<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../model/HomeModel.php';

// Controller : page accueil
class HomeController
{
  // Model home
  private HomeModel $model;

  // Constructeur : init model
  public function __construct()
  {
    $pdo = Database::getConnection();
    $this->model = new HomeModel($pdo);
  }

  // Affiche l'accueil
  public function show(): void
  {
    $latestBooks = $this->model->getLatestBooks(4);
    require __DIR__ . '/../view/home/home.php';
  }
}
