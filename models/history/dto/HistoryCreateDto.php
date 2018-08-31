<?php
namespace app\models\history\dto;

class HistoryCreateDto
{
    public $id;
    public $created;
    public $userId;
    public $ip;
    public $agent;
    public $origin;
    public $destination;
    public $dateTime;
    public $type;
}