<?php

namespace App\Repositories;

interface BidRepositoryInterface {
    public function getRecentlyWon();
    public function getWonCount();
    public function getActiveCount();
    public function getMaxBidsAmount();
    public function getCurBidsAmount();
    public function getWonAmount();
    public function getDataTable();
    public function getWonDataTable();
    public function Htmldom($url);
    public function getRemoteCurBid();
    public function getRemoteData();
    public function getRemoteDetails();
    public function getRemoteEndDate();
    public function getRemoteLocation();
}
