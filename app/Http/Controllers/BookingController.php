<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    public function index(Request $request) {
         $txtphone=$request->txtphone;
         $txtemail=$request->txtemail;
         if($txtphone != ""){
             $phone = $txtphone;
         }else{
             $email = $txtemail;
         }

        $curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'refresh_token=1000.363abc5e60301b1b51b9407b595c4459.4bf1bd86c2c5f1756e7e75d3e10ef9c1&client_id=1000.SK7FAX5FI50XP8GOWXQVP72AAGHLBW&client_secret=de2ac49424ba45cfb2aefca754e5450211cb0b68a2&grant_type=refresh_token',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/x-www-form-urlencoded',
		    'Cookie: b266a5bf57=a711b6da0e6cbadb5e254290f114a026; iamcsr=f38c312c-e6ca-4699-aa12-6e0da5931904; _zcsr_tmp=f38c312c-e6ca-4699-aa12-6e0da5931904'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$data = json_decode($response, true);
		$access_token =  $data['access_token'];

		if($access_token != ""){
            if (isset($phone)){
                $CURLOPT_URL = 'https://www.zohoapis.com/crm/v2/Contacts/search?phone='.$phone;
            }
            elseif (isset($email)){
                $CURLOPT_URL = 'https://www.zohoapis.com/crm/v2/Contacts/search?email='.$email;
            }

			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $CURLOPT_URL,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HTTPHEADER => array(
			    'Authorization: Zoho-oauthtoken '.$access_token
			  ),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			//$databooking = json_decode($response, true);
            return $response;
		}
   }

   public function offer(Request $request) {
   	   $userid = $request->userid;
   	   $ownerid = $request->ownerid;
   	   $inputnight = $request->inputnight;
   	   $dropdownMenuLink = $request->dropdownMenuLink;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'refresh_token=1000.363abc5e60301b1b51b9407b595c4459.4bf1bd86c2c5f1756e7e75d3e10ef9c1&client_id=1000.SK7FAX5FI50XP8GOWXQVP72AAGHLBW&client_secret=de2ac49424ba45cfb2aefca754e5450211cb0b68a2&grant_type=refresh_token',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/x-www-form-urlencoded',
		    'Cookie: b266a5bf57=a711b6da0e6cbadb5e254290f114a026; iamcsr=f38c312c-e6ca-4699-aa12-6e0da5931904; _zcsr_tmp=f38c312c-e6ca-4699-aa12-6e0da5931904'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$data = json_decode($response, true);
		$access_token =  $data['access_token'];

		if($access_token != ""){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Deals',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
			    "data": [
			        {
			            "Contact_Name": {
			                     "id" : '.$userid.'
			                    },
			            "Deal_Name": '.$request->firstname.'" "'.$request->surname.'" (Annivarsory Offer)",
			            "Owner":{
			                     "id" : '.$ownerid.'
			                    },
			            "Primary_Wellness_Goal":[
			                              "Relaxation"
			                                 ],
			            "Package":{
			                     "id" : "3346943000035874298"
			                    },
			            "Lead_Source": "Email",
			             "Amount":1000,
			             "Pipeline":"Standard (Standard)",
			             "Stage":"Qualified",
			             "Closing_Date":"2022-08-16",
			             "Type_of_Rooms":"'.$dropdownMenuLink.'",
			             "Number_of_Nights": '.$inputnight.',
			             "Tags": "WF2022",
			             "Purpose of visit": "Wellness Retreat"
			        }
			    ],
			    "trigger": [
			        "approval",
			        "workflow",
			        "blueprint"
			    ]
			}',
			  CURLOPT_HTTPHEADER => array(
			    'Authorization: Zoho-oauthtoken '.$access_token,
			    'Content-Type: text/plain',
			    'Cookie: 1a99390653=0361cfa6107f6be32a93b6caa457b5fb; crmcsr=75f43a9b-9b07-4dd1-b739-527614cb431a; _zcsr_tmp=75f43a9b-9b07-4dd1-b739-527614cb431a; 1ccad04dca=d8c773df060ae4784b40e4f7c456eeaf; JSESSIONID=9CCD9C1CE4590FF14B221D8D7EFA5C1A'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

		}
   }

    public function first_refer_submit(Request $request){
        $inputnight = $request->inputnight;
        $dropdownMenuLink = $request->dropdownMenuLink;
        $txtphone=$request->txtphone;
        $txtemail=$request->txtemail;
        if($txtphone != ""){
            $phone = $txtphone;
        }else{
            $email = $txtemail;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'refresh_token=1000.363abc5e60301b1b51b9407b595c4459.4bf1bd86c2c5f1756e7e75d3e10ef9c1&client_id=1000.SK7FAX5FI50XP8GOWXQVP72AAGHLBW&client_secret=de2ac49424ba45cfb2aefca754e5450211cb0b68a2&grant_type=refresh_token',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: b266a5bf57=a711b6da0e6cbadb5e254290f114a026; iamcsr=f38c312c-e6ca-4699-aa12-6e0da5931904; _zcsr_tmp=f38c312c-e6ca-4699-aa12-6e0da5931904'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
        $access_token =  $data['access_token'];

        if($access_token != ""){
            if (isset($phone)){
                $CURLOPT_URL = 'https://www.zohoapis.com/crm/v2/Contacts/search?phone='.$phone;
            }
            elseif (isset($email)){
                $CURLOPT_URL = 'https://www.zohoapis.com/crm/v2/Contacts/search?email='.$email;
            }

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $CURLOPT_URL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Zoho-oauthtoken '.$access_token
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
//            return $response;
            $booking_data = json_decode($response, true);
//            dd($booking_data, $httpcode, $booking_data['data'][0]['id']);

            if ($httpcode == 200){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Deals',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
			    "data": [
			    {
			            "Contact_Name": {
			                     "id" : "'.$request->user_id.'"
			                    },
			            "Deal_Name": "'.$request->firstname.' '.$request->surname.' (Annivarsory Offer)",
			            "Owner":{
			                     "id" : "'.$request->ownerid.'"
			                    },
			            "Primary_Wellness_Goal":[
			                              "Relaxation"
			                                 ],
			            "Package":{
			                     "id" : "3346943000035874298"
			                    },
			            "Lead_Source": "Email",
			             "Amount":1000,
			             "Pipeline":"Standard (Standard)",
			             "Stage":"Qualified",
			             "Closing_Date":"2022-08-16",
			             "Type_of_Rooms":"'.$dropdownMenuLink.'",
			             "Number_of_Nights": "'.$inputnight.'",
			             "Tags": "WF2022",
			             "Purpose of visit": "Wellness Retreat"
                },
                {
			            "Contact_Name": {
			                     "id" : "'.$booking_data['data'][0]['id'].'"
			                    },
			            "Deal_Name": "'.$request->first_refer_firstame.' '.$request->first_refer_surname.' (Annivarsory Offer)",
			            "Owner":{
			                     "id" : "'.$booking_data['data'][0]['Owner']['id'].'"
			                    },
			            "Primary_Wellness_Goal":[
			                              "Relaxation"
			                                 ],
			            "Package":{
			                     "id" : "3346943000035874298"
			                    },
			            "Lead_Source": "Email",
			             "Amount":1000,
			             "Pipeline":"Standard (Standard)",
			             "Stage":"Qualified",
			             "Closing_Date":"2022-08-16",
			             "Type_of_Rooms":"'.$dropdownMenuLink.'",
			             "Number_of_Nights": "'.$inputnight.'",
			             "Tags": "WF2022",
			             "Purpose of visit": "Wellness Retreat"
                }
			    ],
			    "trigger": [
			        "approval",
			        "workflow",
			        "blueprint"
			    ]
			}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Zoho-oauthtoken '.$access_token,
                        'Content-Type: text/plain',
                        'Cookie: 1a99390653=0361cfa6107f6be32a93b6caa457b5fb; crmcsr=75f43a9b-9b07-4dd1-b739-527614cb431a; _zcsr_tmp=75f43a9b-9b07-4dd1-b739-527614cb431a; 1ccad04dca=d8c773df060ae4784b40e4f7c456eeaf; JSESSIONID=9CCD9C1CE4590FF14B221D8D7EFA5C1A'
                    ),
                ));
//                dd($request->user_id,$request->firstname,$request->ownerid,$dropdownMenuLink,$inputnight,$booking_data['data'][0]['id'],$request->first_refer_firstame,$booking_data['data'][0]['Owner']['id'],$access_token);
                $response = curl_exec($curl);
//                dd($booking_data['data'][0]['Owner']['id'],$response);
                curl_close($curl);

                return $response;
            }

            else{
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Deals',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
			    "data": [
			        {
			            "Contact_Name": {
			                     "id" : "'.$request->user_id.'"
			                    },
			            "Deal_Name": "'.$request->firstname.' '.$request->surname.' (Annivarsory Offer)",
			            "Owner":{
			                     "id" : "'.$request->ownerid.'"
			                    },
			            "Primary_Wellness_Goal":[
			                              "Relaxation"
			                                 ],
			            "Package":{
			                     "id" : "3346943000035874298"
			                    },
			            "Lead_Source": "Email",
			             "Amount":1000,
			             "Pipeline":"Standard (Standard)",
			             "Stage":"Qualified",
			             "Closing_Date":"2022-08-16",
			             "Type_of_Rooms":"'.$dropdownMenuLink.'",
			             "Number_of_Nights": "'.$inputnight.'",
			             "Tags": "WF2022",
			             "Purpose of visit": "Wellness Retreat"
			        }
			    ],
			    "trigger": [
			        "approval",
			        "workflow",
			        "blueprint"
			    ]
			}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Zoho-oauthtoken '.$access_token,
                        'Content-Type: text/plain',
                        'Cookie: 1a99390653=0361cfa6107f6be32a93b6caa457b5fb; crmcsr=75f43a9b-9b07-4dd1-b739-527614cb431a; _zcsr_tmp=75f43a9b-9b07-4dd1-b739-527614cb431a; 1ccad04dca=d8c773df060ae4784b40e4f7c456eeaf; JSESSIONID=9CCD9C1CE4590FF14B221D8D7EFA5C1A'
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);

                $leads_curl = curl_init();
                curl_setopt_array($leads_curl, array(
                    CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Leads',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
			    "data": [
			        {
			            "First_Name": "'.$request->first_refer_firstame.'",
			            "Last_Name": "'.$request->first_refer_surname.'",
			            "Lead_Source": "WF 2022",
			            "Lead_Status": "New Lead",
			            "Email": "'.$request->txtemail.'",
			            "Country_Code_Mobile": "'.$request->Country_Code_Mobile.'",
			            "Mobile": "'.$request->txtphone.'",
			            "Animesh_Assign": "Yes",
			            "Referred_By": "'.$request->user_id.'",
			            "Referred_Contact_Owner": "'.$request->owner_name.'",
			            "Contact_type" : "FRD"
			        }
			    ],
			    "trigger": [
			        "approval",
			        "workflow",
			        "blueprint"
			    ]
			}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Zoho-oauthtoken '.$access_token,
                        'Content-Type: text/plain',
                        'Cookie: 1a99390653=0361cfa6107f6be32a93b6caa457b5fb; crmcsr=75f43a9b-9b07-4dd1-b739-527614cb431a; _zcsr_tmp=75f43a9b-9b07-4dd1-b739-527614cb431a; 1ccad04dca=d8c773df060ae4784b40e4f7c456eeaf; JSESSIONID=9CCD9C1CE4590FF14B221D8D7EFA5C1A'
                    ),
                ));
                $response = curl_exec($leads_curl);
                curl_close($leads_curl);

                return $response;
            }
        }
    }

    public function second_refer_submit(Request $request){
        $inputnight = $request->inputnight;
        $dropdownMenuLink = $request->dropdownMenuLink;
        if($request->txtphone1 != ""){
            $phone1 = $request->txtphone1;
        }else{
            $email1 = $request->txtemail1;
        }

        if($request->txtphone2 != ""){
            $phone2 = $request->txtphone2;
        }else{
            $email2 = $request->txtemail2;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'refresh_token=1000.363abc5e60301b1b51b9407b595c4459.4bf1bd86c2c5f1756e7e75d3e10ef9c1&client_id=1000.SK7FAX5FI50XP8GOWXQVP72AAGHLBW&client_secret=de2ac49424ba45cfb2aefca754e5450211cb0b68a2&grant_type=refresh_token',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: b266a5bf57=a711b6da0e6cbadb5e254290f114a026; iamcsr=f38c312c-e6ca-4699-aa12-6e0da5931904; _zcsr_tmp=f38c312c-e6ca-4699-aa12-6e0da5931904'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
        $access_token =  $data['access_token'];

        if($access_token != ""){
            if (isset($phone1)){
                $CURLOPT_URL = 'https://www.zohoapis.com/crm/v2/Contacts/search?phone='.$phone1;
            }
            elseif (isset($email1)){
                $CURLOPT_URL = 'https://www.zohoapis.com/crm/v2/Contacts/search?email='.$email1;
            }

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $CURLOPT_URL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Zoho-oauthtoken '.$access_token
                ),
            ));
            $response = curl_exec($curl);
            $httpcode1 = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            $booking_data1 = json_decode($response, true);

            if (isset($phone2)){
                $CURLOPT_URL = 'https://www.zohoapis.com/crm/v2/Contacts/search?phone='.$phone2;
            }
            elseif (isset($email2)){
                $CURLOPT_URL = 'https://www.zohoapis.com/crm/v2/Contacts/search?email='.$email2;
            }

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $CURLOPT_URL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Zoho-oauthtoken '.$access_token
                ),
            ));
            $response = curl_exec($curl);
            $httpcode2 = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            $booking_data2 = json_decode($response, true);

            if ($httpcode1 == 200 && $httpcode2 != 200){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Deals',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
			    "data": [
			    {
			            "Contact_Name": {
			                     "id" : "'.$request->user_id.'"
			                    },
			            "Deal_Name": "'.$request->firstname.' '.$request->surname.' (Annivarsory Offer)",
			            "Owner":{
			                     "id" : "'.$request->ownerid.'"
			                    },
			            "Primary_Wellness_Goal":[
			                              "Relaxation"
			                                 ],
			            "Package":{
			                     "id" : "3346943000035874298"
			                    },
			            "Lead_Source": "Email",
			             "Amount":1000,
			             "Pipeline":"Standard (Standard)",
			             "Stage":"Qualified",
			             "Closing_Date":"2022-08-16",
			             "Type_of_Rooms":"'.$dropdownMenuLink.'",
			             "Number_of_Nights": "'.$inputnight.'",
			             "Tags": "WF2022",
			             "Purpose of visit": "Wellness Retreat"
			        },
			        {
			            "Contact_Name": {
			                     "id" : "'.$booking_data1['data'][0]['id'].'"
			                    },
			            "Deal_Name": "'.$request->first_refer_firstame.' '.$request->first_refer_surname.' (Annivarsory Offer)",
			            "Owner":{
			                     "id" : "'.$booking_data1['data'][0]['Owner']['id'].'"
			                    },
			            "Primary_Wellness_Goal":[
			                              "Relaxation"
			                                 ],
			            "Package":{
			                     "id" : "3346943000035874298"
			                    },
			            "Lead_Source": "Email",
			             "Amount":1000,
			             "Pipeline":"Standard (Standard)",
			             "Stage":"Qualified",
			             "Closing_Date":"2022-08-16",
			             "Type_of_Rooms":"'.$dropdownMenuLink.'",
			             "Number_of_Nights": "'.$inputnight.'",
			             "Tags": "WF2022",
			             "Purpose of visit": "Wellness Retreat"
			        }
			    ],
			    "trigger": [
			        "approval",
			        "workflow",
			        "blueprint"
			    ]
			}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Zoho-oauthtoken '.$access_token,
                        'Content-Type: text/plain',
                        'Cookie: 1a99390653=0361cfa6107f6be32a93b6caa457b5fb; crmcsr=75f43a9b-9b07-4dd1-b739-527614cb431a; _zcsr_tmp=75f43a9b-9b07-4dd1-b739-527614cb431a; 1ccad04dca=d8c773df060ae4784b40e4f7c456eeaf; JSESSIONID=9CCD9C1CE4590FF14B221D8D7EFA5C1A'
                    ),
                ));
                $response_deals = curl_exec($curl);
                curl_close($curl);

                $leads_curl = curl_init();
                curl_setopt_array($leads_curl, array(
                    CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Leads',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
			    "data": [
			        {
			            "First_Name": "'.$request->second_refer_firstame.'",
			            "Last_Name": "'.$request->second_refer_surname.'",
			            "Lead_Source": "WF 2022",
			            "Lead_Status": "New Lead",
			            "Email": "'.$request->txtemail2.'",
			            "Country_Code_Mobile": "'.$request->Country_Code_Mobile2.'",
			            "Mobile": "'.$request->txtphone2.'",
			            "Animesh_Assign": "Yes",
			            "Referred_By": "'.$request->user_id.'",
			            "Referred_Contact_Owner": "'.$request->owner_name.'",
			            "Contact_type" : "FRD"
			        }
			    ],
			    "trigger": [
			        "approval",
			        "workflow",
			        "blueprint"
			    ]
			}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Zoho-oauthtoken '.$access_token,
                        'Content-Type: text/plain',
                        'Cookie: 1a99390653=0361cfa6107f6be32a93b6caa457b5fb; crmcsr=75f43a9b-9b07-4dd1-b739-527614cb431a; _zcsr_tmp=75f43a9b-9b07-4dd1-b739-527614cb431a; 1ccad04dca=d8c773df060ae4784b40e4f7c456eeaf; JSESSIONID=9CCD9C1CE4590FF14B221D8D7EFA5C1A'
                    ),
                ));
                $response_leads = curl_exec($leads_curl);
                curl_close($leads_curl);

                return ['deals_data' => $response_deals, 'leads_data' => $response_leads, "leads_data_for" => "second_refer"];
            }
            elseif ($httpcode2 == 200 && $httpcode1 != 200){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Deals',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
			    "data": [
			    {
			            "Contact_Name": {
			                     "id" : "'.$request->user_id.'"
			                    },
			            "Deal_Name": "'.$request->firstname.' '.$request->surname.' (Annivarsory Offer)",
			            "Owner":{
			                     "id" : "'.$request->ownerid.'"
			                    },
			            "Primary_Wellness_Goal":[
			                              "Relaxation"
			                                 ],
			            "Package":{
			                     "id" : "3346943000035874298"
			                    },
			            "Lead_Source": "Email",
			             "Amount":1000,
			             "Pipeline":"Standard (Standard)",
			             "Stage":"Qualified",
			             "Closing_Date":"2022-08-16",
			             "Type_of_Rooms":"'.$dropdownMenuLink.'",
			             "Number_of_Nights": "'.$inputnight.'",
			             "Tags": "WF2022",
			             "Purpose of visit": "Wellness Retreat"
			        },
			        {
			            "Contact_Name": {
			                     "id" : "'.$booking_data2['data'][0]['id'].'"
			                    },
			            "Deal_Name": "'.$request->second_refer_firstame.' '.$request->second_refer_surname.' (Annivarsory Offer)",
			            "Owner":{
			                     "id" : "'.$booking_data2['data'][0]['Owner']['id'].'"
			                    },
			            "Primary_Wellness_Goal":[
			                              "Relaxation"
			                                 ],
			            "Package":{
			                     "id" : "3346943000035874298"
			                    },
			            "Lead_Source": "Email",
			             "Amount":1000,
			             "Pipeline":"Standard (Standard)",
			             "Stage":"Qualified",
			             "Closing_Date":"2022-08-16",
			             "Type_of_Rooms":"'.$dropdownMenuLink.'",
			             "Number_of_Nights": "'.$inputnight.'",
			             "Tags": "WF2022",
			             "Purpose of visit": "Wellness Retreat"
			        }
			    ],
			    "trigger": [
			        "approval",
			        "workflow",
			        "blueprint"
			    ]
			}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Zoho-oauthtoken '.$access_token,
                        'Content-Type: text/plain',
                        'Cookie: 1a99390653=0361cfa6107f6be32a93b6caa457b5fb; crmcsr=75f43a9b-9b07-4dd1-b739-527614cb431a; _zcsr_tmp=75f43a9b-9b07-4dd1-b739-527614cb431a; 1ccad04dca=d8c773df060ae4784b40e4f7c456eeaf; JSESSIONID=9CCD9C1CE4590FF14B221D8D7EFA5C1A'
                    ),
                ));
                $response_deals = curl_exec($curl);
                curl_close($curl);

                $leads_curl = curl_init();
                curl_setopt_array($leads_curl, array(
                    CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Leads',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
			    "data": [
			        {
			            "First_Name": "'.$request->first_refer_firstame.'",
			            "Last_Name": "'.$request->first_refer_surname.'",
			            "Lead_Source": "WF 2022",
			            "Lead_Status": "New Lead",
			            "Email": "'.$request->txtemail1.'",
			            "Country_Code_Mobile": "'.$request->Country_Code_Mobile1.'",
			            "Mobile": "'.$request->txtphone1.'",
			            "Animesh_Assign": "Yes",
			            "Referred_By": "'.$request->user_id.'",
			            "Referred_Contact_Owner": "'.$request->owner_name.'",
			            "Contact_type" : "FRD"
			        }
			    ],
			    "trigger": [
			        "approval",
			        "workflow",
			        "blueprint"
			    ]
			}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Zoho-oauthtoken '.$access_token,
                        'Content-Type: text/plain',
                        'Cookie: 1a99390653=0361cfa6107f6be32a93b6caa457b5fb; crmcsr=75f43a9b-9b07-4dd1-b739-527614cb431a; _zcsr_tmp=75f43a9b-9b07-4dd1-b739-527614cb431a; 1ccad04dca=d8c773df060ae4784b40e4f7c456eeaf; JSESSIONID=9CCD9C1CE4590FF14B221D8D7EFA5C1A'
                    ),
                ));
                $response_leads = curl_exec($leads_curl);
                curl_close($leads_curl);

                return ['deals_data' => $response_deals, 'leads_data' => $response_leads, "leads_data_for" => "first_refer"];
            }
            elseif ($httpcode1 == 200 && $httpcode2 == 200){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Deals',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
			    "data": [
			    {
			            "Contact_Name": {
			                     "id" : "'.$request->user_id.'"
			                    },
			            "Deal_Name": "'.$request->firstname.' '.$request->surname.' (Annivarsory Offer)",
			            "Owner":{
			                     "id" : "'.$request->ownerid.'"
			                    },
			            "Primary_Wellness_Goal":[
			                              "Relaxation"
			                                 ],
			            "Package":{
			                     "id" : "3346943000035874298"
			                    },
			            "Lead_Source": "Email",
			             "Amount":1000,
			             "Pipeline":"Standard (Standard)",
			             "Stage":"Qualified",
			             "Closing_Date":"2022-08-16",
			             "Type_of_Rooms":"'.$dropdownMenuLink.'",
			             "Number_of_Nights": "'.$inputnight.'",
			             "Tags": "WF2022",
			             "Purpose of visit": "Wellness Retreat"
			        },
			        {
			            "Contact_Name": {
			                     "id" : "'.$booking_data1['data'][0]['id'].'"
			                    },
			            "Deal_Name": "'.$request->first_refer_firstame.' '.$request->first_refer_surname.' (Annivarsory Offer)",
			            "Owner":{
			                     "id" : "'.$booking_data1['data'][0]['Owner']['id'].'"
			                    },
			            "Primary_Wellness_Goal":[
			                              "Relaxation"
			                                 ],
			            "Package":{
			                     "id" : "3346943000035874298"
			                    },
			            "Lead_Source": "Email",
			             "Amount":1000,
			             "Pipeline":"Standard (Standard)",
			             "Stage":"Qualified",
			             "Closing_Date":"2022-08-16",
			             "Type_of_Rooms":"'.$dropdownMenuLink.'",
			             "Number_of_Nights": "'.$inputnight.'",
			             "Tags": "WF2022",
			             "Purpose of visit": "Wellness Retreat"
			        },
			        {
			            "Contact_Name": {
			                     "id" : "'.$booking_data2['data'][0]['id'].'"
			                    },
			            "Deal_Name": "'.$request->second_refer_firstame.' '.$request->second_refer_surname.' (Annivarsory Offer)",
			            "Owner":{
			                     "id" : "'.$booking_data2['data'][0]['Owner']['id'].'"
			                    },
			            "Primary_Wellness_Goal":[
			                              "Relaxation"
			                                 ],
			            "Package":{
			                     "id" : "3346943000035874298"
			                    },
			            "Lead_Source": "Email",
			             "Amount":1000,
			             "Pipeline":"Standard (Standard)",
			             "Stage":"Qualified",
			             "Closing_Date":"2022-08-16",
			             "Type_of_Rooms":"'.$dropdownMenuLink.'",
			             "Number_of_Nights": "'.$inputnight.'",
			             "Tags": "WF2022",
			             "Purpose of visit": "Wellness Retreat"
			        }
			    ],
			    "trigger": [
			        "approval",
			        "workflow",
			        "blueprint"
			    ]
			}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Zoho-oauthtoken '.$access_token,
                        'Content-Type: text/plain',
                        'Cookie: 1a99390653=0361cfa6107f6be32a93b6caa457b5fb; crmcsr=75f43a9b-9b07-4dd1-b739-527614cb431a; _zcsr_tmp=75f43a9b-9b07-4dd1-b739-527614cb431a; 1ccad04dca=d8c773df060ae4784b40e4f7c456eeaf; JSESSIONID=9CCD9C1CE4590FF14B221D8D7EFA5C1A'
                    ),
                ));
                $response_deals = curl_exec($curl);
                curl_close($curl);

                return ['deals_data' => $response_deals, 'leads_data' => '', "leads_data_for" => ''];
            }
            elseif ($httpcode1 != 200 && $httpcode2 != 200){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Deals',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
			    "data": [
			    {
			            "Contact_Name": {
			                     "id" : "'.$request->user_id.'"
			                    },
			            "Deal_Name": "'.$request->firstname.' '.$request->surname.' (Annivarsory Offer)",
			            "Owner":{
			                     "id" : "'.$request->ownerid.'"
			                    },
			            "Primary_Wellness_Goal":[
			                              "Relaxation"
			                                 ],
			            "Package":{
			                     "id" : "3346943000035874298"
			                    },
			            "Lead_Source": "Email",
			             "Amount":1000,
			             "Pipeline":"Standard (Standard)",
			             "Stage":"Qualified",
			             "Closing_Date":"2022-08-16",
			             "Type_of_Rooms":"'.$dropdownMenuLink.'",
			             "Number_of_Nights": "'.$inputnight.'",
			             "Tags": "WF2022",
			             "Purpose of visit": "Wellness Retreat"
			        }
			    ],
			    "trigger": [
			        "approval",
			        "workflow",
			        "blueprint"
			    ]
			}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Zoho-oauthtoken '.$access_token,
                        'Content-Type: text/plain',
                        'Cookie: 1a99390653=0361cfa6107f6be32a93b6caa457b5fb; crmcsr=75f43a9b-9b07-4dd1-b739-527614cb431a; _zcsr_tmp=75f43a9b-9b07-4dd1-b739-527614cb431a; 1ccad04dca=d8c773df060ae4784b40e4f7c456eeaf; JSESSIONID=9CCD9C1CE4590FF14B221D8D7EFA5C1A'
                    ),
                ));
                $response_deals = curl_exec($curl);
                curl_close($curl);

                $leads_curl = curl_init();
                curl_setopt_array($leads_curl, array(
                    CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Leads',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
			    "data": [
			        {
			            "First_Name": "'.$request->first_refer_firstame.'",
			            "Last_Name": "'.$request->first_refer_surname.'",
			            "Lead_Source": "WF 2022",
			            "Lead_Status": "New Lead",
			            "Email": "'.$request->txtemail1.'",
			            "Country_Code_Mobile": "'.$request->Country_Code_Mobile1.'",
			            "Mobile": "'.$request->txtphone1.'",
			            "Animesh_Assign": "Yes",
			            "Referred_By": "'.$request->user_id.'",
			            "Referred_Contact_Owner": "'.$request->owner_name.'",
			            "Contact_type" : "FRD"
			        },
			        {
			            "First_Name": "'.$request->second_refer_firstame.'",
			            "Last_Name": "'.$request->second_refer_surname.'",
			            "Lead_Source": "WF 2022",
			            "Lead_Status": "New Lead",
			            "Email": "'.$request->txtemail2.'",
			            "Country_Code_Mobile": "'.$request->Country_Code_Mobile2.'",
			            "Mobile": "'.$request->txtphone2.'",
			            "Animesh_Assign": "Yes",
			            "Referred_By": "'.$request->user_id.'",
			            "Referred_Contact_Owner": "'.$request->owner_name.'",
			            "Contact_type" : "FRD"
			        }
			    ],
			    "trigger": [
			        "approval",
			        "workflow",
			        "blueprint"
			    ]
			}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Zoho-oauthtoken '.$access_token,
                        'Content-Type: text/plain',
                        'Cookie: 1a99390653=0361cfa6107f6be32a93b6caa457b5fb; crmcsr=75f43a9b-9b07-4dd1-b739-527614cb431a; _zcsr_tmp=75f43a9b-9b07-4dd1-b739-527614cb431a; 1ccad04dca=d8c773df060ae4784b40e4f7c456eeaf; JSESSIONID=9CCD9C1CE4590FF14B221D8D7EFA5C1A'
                    ),
                ));
                $response_leads = curl_exec($leads_curl);
                curl_close($leads_curl);

                return ['deals_data' => $response_deals, 'leads_data' => $response_leads, "leads_data_for" => "both_refer"];
            }

        }
    }

}
