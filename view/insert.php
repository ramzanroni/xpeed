<?php
require '../model/xpeed.php';
session_start();
// $sporttb = isset($_SESSION['sporttbl0']) ? unserialize($_SESSION['sporttbl0']) : new sports();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="../libs/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
  integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
/>
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
  integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
></script>
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Add Xpeed <a href="/xpeedstudio" class="btn btn-success">View List</a></h2>
                </div>
                <p>Please fill this form and submit to add Xpeed record in the database.</p>
                <!-- <form action="../index.php?act=add" method="post" > -->
                <form method="post">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" name="amount" id="amount" class="form-control" value="">
                            <span class="help-block" id="amount_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Buyer Name</label>
                            <input name="buyer" id="buyer" class="form-control" value="">
                            <span class="help-block" id="buyer_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Receipt Id</label>
                            <input name="receipt_id" id="receipt_id" class="form-control" value="">
                            <span class="help-block" id="receipt_id_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Items</label>
                            <input name="items" id="items">
                            <span class="help-block" id="items_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Buyer Email</label>
                            <input name="buyer_email" id="buyer_email" class="form-control" value="">
                            <span class="help-block" id="buyer_email_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>City</label>
                            <input name="city" id="city" class="form-control" value="">
                            <span class="help-block" id="city_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input name="phone" id="phone" class="form-control" value="">
                            <span class="help-block" id="phone_error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Note</label>
                            <textarea name="note" id="note" class="form-control" rows="5"></textarea>
                            <span class="help-block" id="note_error"></span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <input type="button" onclick='addData()' name="addbtn" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $("#items").selectize({
  delimiter: ",",
  persist: false,
  create: function (input) {
    return {
        value: input,
        text: input,
    };
  },
});
    function addData() {
        let amount = $("#amount").val();
        let buyer = $("#buyer").val();
        let receipt_id = $("#receipt_id").val();
        let items = $("#items").val();
        let buyer_email = $("#buyer_email").val();
        let city = $("#city").val();
        let phone = $("#phone").val();
        let note = $("#note").val();
        let flag = 0;

        if ($.isNumeric(amount) == false || amount == '') {
            flag = 1;
            $("#amount_error").html('Amount cannot be null or string text.');
        } else {
            $("#amount_error").html('');
        }
        if (buyer.length > 20 || buyer == '') {
            flag = 1;
            $("#buyer_error").html('only text, spaces and numbers, not more than 20 characters');
        } else {
            $("#buyer_error").html('');
        }
        if ($.isNumeric(receipt_id) == true || receipt_id == '') {
            flag = 1;
            $("#receipt_id_error").html('Use only text.');
        } else {
            $("#receipt_id_error").html('');
        }
        if (items == '') {
            flag = 1;
            $("#items_error").html("Item cannot be empty");
        } else {
            $("#items_error").html("");
        }
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailRegex.test(buyer_email)) {
            $("#buyer_email_error").html('');
        } else {
            flag = 1;
            $("#buyer_email_error").html('Invalid Email address');
        }
        const notewords = note.split(" ");
        const wordCount = notewords.length;
        if (wordCount > 20 || note == '') {
            flag = 1;
            $("#note_error").html('Note must be between 20 word. Cannot be null');
        } else {
            $("#note_error").html('');
        }
        if (city == '') {
            flag = 1;
            $("#city_error").html("City cannot be null");
        } else {
            $("#city_error").html("");
        }
        if ($.isNumeric(phone)) {
            var phoneReg = new RegExp(/(^(\+88|0088)?(01){1}[56789]{1}(\d){8})$/);
            if (!phoneReg.test(phone)) {
                $("#phone_error").html("Please Enter a Valid Number");
                flag = 1;
            } else {
                $("#phone_error").html("");
            }
        } else {
            $("#phone_error").html("Phone number can't be null and osnly numeric number formate acceptable.");
            flag = 1;
        }
        if (flag == 0) {
            var check = 'storeData';
            $.ajax({
                url: "../index.php?act=add",
                type: "POST",

                data: {
                    check: check,
                    amount: amount,
                    buyer: buyer,
                    receipt_id: receipt_id,
                    items: items,
                    buyer_email: buyer_email,
                    city: city,
                    phone: phone,
                    note: note,
                },
                success: function(response) {
                    //    console.log(response);
                    if (response == 'success') {
                        alert('Data insert Success');
                        setTimeout(location.reload(), 1000);
                    } else if (response == 'notpermitted') {
                        alert('You can not multiple account withen 24 hour');
                    } else {
                        var output = JSON.parse(response);
                        $("#amount_error").html(output.amount_msg);
                        $("#buyer_email_error").html(output.buyer_email_msg);
                        $("#buyer_error").html(output.buyer_msg);
                        $("#city_error").html(output.city_msg);
                        $("#items_error").html(output.items_msg);
                        $("#note_error").html(output.note_msg);
                        $("#phone_error").html(output.phone_msg);
                        $("#receipt_id_error").html(output.receipt_id_msg);
                    }

                },
            });
        }
    }
</script>