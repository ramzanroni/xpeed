<?php
require 'model/xpeedModel.php';
require 'model/xpeed.php';
require_once 'config.php';

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

class xpeedController
{

    function __construct()
    {
        $this->objconfig = new config();
        $this->objsm =  new xpeedModel($this->objconfig);
    }
    // mvc handler request
    public function mvcHandler()
    {
        $act = isset($_GET['act']) ? $_GET['act'] : NULL;
        switch ($act) {
            case 'add':
                $this->insert();
                break;
            default:
                $this->list();
        }
    }
   
    // page redirection
    public function pageRedirect($url)
    {
        header('Location:' . $url);
    }
    // check validation
    public function checkValidation($xpeedtbl)
    {
        $noerror = true;
        // Validate category
        if (!is_numeric($xpeedtbl->amount) || $xpeedtbl->amount == '') {
            $xpeedtbl->amount_msg = 'Amount field not empty and must use integer value';
            $noerror = false;
        } else {
            $xpeedtbl->amount_msg = '';
        }
        if (strlen($xpeedtbl->buyer) > 20 || $xpeedtbl->buyer == '') {
            $xpeedtbl->buyer_msg = 'Buyer name must into 20 char and not null';
            $noerror = false;
        } else {
            $xpeedtbl->buyer_msg = '';
        }
        if ($xpeedtbl->receipt_id == '') {
            $xpeedtbl->receipt_id_msg = 'Buyer name must into 20 char and not null';
            $noerror = false;
        } else {
            $xpeedtbl->receipt_id_msg = '';
        }
        if (is_numeric($xpeedtbl->items) || $xpeedtbl->items == '') {
            $xpeedtbl->items_msg = 'Text only';
            $noerror = false;
        } else {
            $xpeedtbl->items_msg = '';
        }
        if (!filter_var($xpeedtbl->buyer_email, FILTER_VALIDATE_EMAIL)) {
            $xpeedtbl->email_msg = 'Not A valid Email';
            $noerror = false;
        } else {
            $xpeedtbl->email_msg = '';
        }
        if (str_word_count($xpeedtbl->note) > 20 || $xpeedtbl->note == '') {
            $xpeedtbl->note_msg = 'Not more then 20 word and not null';
            $noerror = false;
        } else {
            $xpeedtbl->note_msg = '';
        }
        if ($xpeedtbl->city == '') {
            $xpeedtbl->city_msg = 'City not null';
            $noerror = false;
        } else {
            $xpeedtbl->city_msg = '';
        }

        if (preg_match('/(^(\+88|0088)?(01){1}[3456789]{1}(\d){8})$/', $xpeedtbl->phone)) {
            $xpeedtbl->phone_msg = '';
        } else {
            $xpeedtbl->phone_msg = 'Invalid Phone number';
            $noerror = false;
        }
        return $noerror;
    }
    // add new record
    public function insert()
    {
        try {
            if (isset($_COOKIE['userInfo'])) {
                echo "notpermitted";
            } else {


                $xpeedtbl = new xpeed();
                // read form value
                $xpeedtbl->amount = trim($_POST['amount']);
                $xpeedtbl->buyer = trim($_POST['buyer']);
                $xpeedtbl->receipt_id = trim($_POST['receipt_id']);
                $xpeedtbl->items = trim($_POST['items']);
                $xpeedtbl->buyer_email = trim($_POST['buyer_email']);
                $xpeedtbl->city = trim($_POST['city']);
                $xpeedtbl->phone = trim($_POST['phone']);
                $xpeedtbl->note = trim($_POST['note']);
                $xpeedtbl->buyer_ip = $_SERVER['REMOTE_ADDR'];
                $xpeedtbl->hash_key = hash('sha512', $xpeedtbl->receipt_id);
                $xpeedtbl->entry_by = 1;
                //call validation
                $chk = $this->checkValidation($xpeedtbl);
                if ($chk) {
                    //call insert record            
                    $pid = $this->objsm->insertRecord($xpeedtbl);
                    if ($pid > 0) {
                        // $this->list();
                        setcookie('userInfo', true,  time() + 86400);
                        echo 'success';
                    } else {
                        echo "Somthing is wrong..., try again.";
                    }
                } else {
                    echo json_encode($xpeedtbl);;
                }
            }
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }
    

    public function list()
    {
        if (!isset($_POST['check'])) {
            $result = $this->objsm->selectRecord(0);
            include "view/list.php";
        } else {
            $result = $this->objsm->searchDateWise($_POST['startDate'], $_POST['endDate'], $_POST['id']);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['amount'] . "</td>";
                echo "<td>" . $row['buyer'] . "</td>";
                echo "<td>" . $row['receipt_id'] . "</td>";
                echo "<td>" . $row['items'] . "</td>";
                echo "<td>" . $row['buyer_email'] . "</td>";
                echo "<td>" . $row['buyer_ip'] . "</td>";
                echo "<td>" . $row['note'] . "</td>";
                echo "<td>" . $row['city'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['entry_at'] . "</td>";

                echo "</tr>";
            }
        }
    }
}
