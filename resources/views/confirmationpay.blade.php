<?php
    $ApiKey = "aeajec3aw51153Z26HIYIe8DnZ";
    $merchant_id = $_REQUEST['merchant_id'];
    $transactionState = $_REQUEST['response_code_pol'];
    $referenceCode = $_REQUEST['reference_sale'];
    $transaction_date = $_REQUEST['transaction_date'];
    $TX_VALUE = $_REQUEST['value'];
    $New_value = number_format($TX_VALUE, 1, '.', '');
    $currency = $_REQUEST['currency'];
    $reference_pol = $_REQUEST['reference_pol'];
    $extra1 = $_REQUEST['extra1'];
    $extra2 = $_REQUEST['extra2'];
    $description = $_REQUEST['description'];
    $buyerEmail = $_REQUEST["email_buyer"];
    $transactionId = $_REQUEST['transactionId'];
    //$firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
    //$firmacreada = md5($firma_cadena);
    //$firma = $_REQUEST['signature'];
    //$cus = $_REQUEST['cus'];
    //$pseBank = $_REQUEST['pseBank'];
    //$lapPaymentMethod = $_REQUEST['lapPaymentMethod'];

    if ($_REQUEST['response_code_pol'] == 4 ) {
        $estadoTx = "TRANSACCIÓN APROBADA";
    }

    else if ($_REQUEST['response_code_pol'] == 6 ) {
        $estadoTx = "TRANSACCIÓN RECHAZADA";
    }

    else if ($_REQUEST['response_code_pol'] == 104 ) {
        $estadoTx = "ERROR";
    }

    else if ($_REQUEST['response_code_pol'] == 7 ) {
        $estadoTx = "PAGO PENDIENTE";
    }

    else {
        $estadoTx=$_REQUEST['mensaje'];
    }
?>

<input type="hidden" id="extra2" value="<?= $extra2?>">
<input type="hidden" id="transactionState" value="<?= $transactionState?>">
<input type="hidden" id="referenceCode" value="<?= $referenceCode?>">
<input type="hidden" id="reference_pol" value="<?= $reference_pol?>">
<input type="hidden" id="estadoTx" value="<?= $estadoTx?>">
<input type="hidden" id="buyerEmail" value="<?= $buyerEmail?>">
<input type="hidden" id="amount" value="<?= $New_value?>">
<input type="hidden" id="extra1" value="<?= $extra1?>">
                                        
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
    integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
    crossorigin="anonymous"></script>
<script>
    async function paySuscription(data_body) {
        const res_pay_suscription = await fetch(`/api/v1/user/pay_suscription`, {
                method: 'POST', //Request Type
                //body: formData, //post body
                body: JSON.stringify(data_body),
                headers: {
                    "Content-Type": "application/json",
                },
            });
            await res_pay_suscription.json();
    }

    async function payPauta(data_body) {
        const res_pay_pauta = await fetch(`/api/v1/pautasusers/payment_state`, {
            method: 'POST', //Request Type
            //body: formData, //post body
            body: JSON.stringify(data_body),
            headers: {
                "Content-Type": "application/json",
            },
        });
        await res_pay_pauta.json();
    }
    $( document ).ready(function() {
        let type_pay = $("#extra2").val()
        let transactionState = $("#transactionState").val()
        let referenceCode = $("#referenceCode").val()
        let reference_pol = $("#reference_pol").val()
        let estadoTx = $("#estadoTx").val() + 'CONFIRMATIONPAY'
        let buyerEmail = $("#buyerEmail").val()
        let amount = $("#amount").val()
        let extra1 = $("#extra1").val()
        if(type_pay == 'SUSCRIPTION'){
            let splExtra1 = extra1.split('+');

            let data_body = {
                id: splExtra1[0],
                start_date_subscriber: splExtra1[1],
                end_date_subscriber: splExtra1[2],
                payment_reference: type_pay,
                amount: amount,
                is_approved: transactionState != 4 ? transactionState == 7 ? 1 : 0 : 2,
                reference_code: referenceCode,
                reference_pol: reference_pol,
                estado_tx: estadoTx,
                buyer_email: buyerEmail
            }
            paySuscription(data_body)
        }else{
            //PAGO DE PAUTA
            let data_body = {
                user_id: extra1,
                valor: amount,
                is_approved: transactionState != 4 ? transactionState == 7 ? 1 : 0 : 2,
                reference_payment: referenceCode,
                reference_pol: reference_pol,
                estadoTx: estadoTx,
                buyer_email: buyerEmail
            } 
            payPauta(data_body)
        }
    });
</script>  
