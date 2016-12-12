<?php

namespace App\Repositories;

interface BidRepositoryInterface {
    public function getWonCount();
    public function getActiveCount();
    public function getMaxBidsAmount();
    public function getCurBidsAmount();
    public function getDataTable();
    public function getWonDataTable();
    public function getRemoteData($url);
}
