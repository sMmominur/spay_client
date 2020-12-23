<?php

namespace App\Http\Controllers;
use App\Models\SPClient;
use Illuminate\Http\Request;
use DB;

class SPClientController extends Controller{


	protected $merchant_username ='spaytest';
    protected $merchant_password ='JehPNXF58rXs';
    protected $client_ip ='127.0.0.1';
    protected $merchant_key_prefix='NOK';
    protected $tx_id;

	public function send(Request $request){
		$amount_as_str = $request->payamount;
		$remove_leading_char = ltrim($amount_as_str, "0");
		$amount =(int)$remove_leading_char;
		$success_url = null;
		if($amount>=1){
			$tx_id =  $this->merchant_key_prefix.uniqid();
			$return_url = route('sp_response');

			if ($success_url) {
				$return_url .= "?success_url={$success_url}";
			}
			$xml_data = 'spdata=<?xml version="1.0" encoding="utf-8"?>
								<shurjoPay><merchantName>' . $this->merchant_username . '</merchantName>
								<merchantPass>' . $this->merchant_password . '</merchantPass>
								<userIP>' . $this->client_ip . '</userIP>
								<uniqID>' . $tx_id . '</uniqID>
								<totalAmount>' . $amount . '</totalAmount>
								<paymentOption>shurjopay</paymentOption>
								<returnURL>' . $return_url . '</returnURL></shurjoPay>';
			
			$ch = curl_init();
			$server_url = 'https://shurjotest.com/sp-data.php';
			$url = $server_url . "/sp-data.php";
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);                
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			print_r($response);
		}
		else{
			echo "<div> <h1 style='color:#f0ad4e;padding:50px;text-align:center'>Amount Can't be less than 1</h1></div>";
		}
	}
	

	public function response(Request $request){
        $server_url = 'https://shurjotest.com/sp-data.php';
        $response_encrypted = $request->spdata;
        $response_decrypted = file_get_contents("https://shurjotest.com/merchant/decrypt.php?data=" . $response_encrypted);
        $data = simplexml_load_string($response_decrypted) or die("Error: Cannot create object");

		$bankResponse = json_encode($data);
		$tx_id = $data->txID;
		$bank_tx_id = $data->bankTxID;
        $amount = $data->txnAmount;
        $bank_status = $data->bankTxStatus;
        $sp_code = $data->spCode;
        $sp_code_des = $data->spCodeDes;
        $sp_payment_option = $data->paymentOption;
		$status = "";
		$client_ip = $_SERVER['REMOTE_ADDR'];

        switch ($sp_code) {
            case '000':
                $res = array('status' => true, 'msg' => 'Action Successful');
                $status = "Success";
                break;
            case '001':
                $status = "Failed";
                $res = array('status' => false, 'msg' => 'Action Failed');
                break;
		}
		
		$success_url = $request->get('success_url');

        if ($success_url) {
            header("location:" . $success_url . "?status={$status}&msg={$res['msg']}&tx_id={$tx_id}&bank_tx_id={$bank_tx_id}"
                . "&amount={$amount}&bank_status={$bank_status}&sp_code={$sp_code}" .
                "&sp_code_des={$sp_code_des}&sp_payment_option={$sp_payment_option}");
		}
		
        if ($res['status']) {
            $query = DB::insert("insert into s_p_clients (amount,txt_id,instrument,client_ip,bank_tx_id,return_url, sp_code,status)
            values('$amount','$tx_id','$sp_payment_option','$client_ip','$bank_tx_id','$bankResponse','$sp_code','$status')");
			echo "<div> <h1 style='color:green;padding:50px;text-align:center'>Your payment has been successful</h1></div>";
            die();
		}
		
		 else {
			$query = DB::insert("insert into s_p_clients (amount,txt_id,instrument,client_ip,bank_tx_id,return_url, sp_code,status)
            values('$amount','$tx_id','$sp_payment_option','$client_ip','$bank_tx_id','$bankResponse','$sp_code','$status')");
		 	echo "<div> <h1 style='color:red;padding:50px;text-align:center'>Your Payment Failed.Try Again</h1></div>";
             die();
		 }
		
    }
	



	
	

    
}
