<?php

namespace App\Repositories;

interface BidRepositoryInterface {
    public function getWonCount();
    public function getActiveCount();
    public function getMaxBidsAmount();
    public function getCurBidsAmount();
    public function getDataTable();
    public function getWonDataTable();
    public function Htmldom($url);
    public function getRemoteCurBid();
    public function getRemoteData();
    public function getRemoteDetails();
    public function getRemoteEndDate();
    public function getRemoteLocation();
}
