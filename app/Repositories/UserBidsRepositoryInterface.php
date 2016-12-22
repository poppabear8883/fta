<?php

namespace App\Repositories;

interface UserBidsRepositoryInterface {
    public function getRecentlyWon();
    public function getWonCount();
    public function getActiveCount();
    public function getMaxBidsAmount();
    public function getCurBidsAmount();
    public function getWonAmount();
    public function getDataTable();
    public function getWonDataTable();
}
