<?php

class xpeed
{
    // table fields
    public $id;
    public $amount;
    public $buyer;
    public $receipt_id;
    public $items;
    public $buyer_email;
    public $buyer_ip;
    public $city;
    public $note;
    public $phone;
    public $hash_key;
    public $entry_at;
    public $entry_by;



    // message string
    public $id_msg;
    public $amount_msg;
    public $buyer_msg;
    public $receipt_id_msg;
    public $items_msg;
    public $buyer_email_msg;
    public $buyer_ip_msg;
    public $city_msg;
    public $note_msg;

    public $phone_msg;
    public $hash_key_msg;
    public $entry_at_msg;
    public $entry_by_msg;

    // constructor set default value
    function __construct()
    {
        $id=$amount=0;
        $buyer=$name=$items=$buyer_email=$buyer_ip=$city=$note=$phone=$hash_key=$entry_at=$entry_by=$receipt_id="";
        $id_msg=$amount_msg=$buyer_msg=$receipt_id_msg=$items_msg=$buyer_email_msg=$buyer_ip_msg=$city_msg=$note_msg=$phone_msg=$hash_key_msg=$entry_at_msg=$entry_by_msg="";
    }
}

?>