<?php

class NaussApi
{
    //private $baseUrl = "https://selfservice9.bmeholding.com:8081/naussadm/api/admission/";
    private $baseUrl = "https://193.122.73.144/naussadm/api/admission/";

    private $token = "i9G0vbjMKqTPY3wS276Ghx0lx7UtzfV30vx60PsWPmbciSD7rm98Ws2bsWFbvRim";
    //https://193.122.73.144/naussadm/api/admission/push-applicant
    //https://193.122.73.144/naussadm/api/admission/push-payments

    private function sendRequest($endpoint, $data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $this->token,
                "Content-Type: application/json",
                "lang: EN"
            ],
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($curl);
//return $response;
        if (curl_errno($curl)) {
            throw new Exception("cURL Error: " . curl_error($curl));
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return [
            "status" => $httpCode,
            "body" => json_decode($response, true)
        ];
    }

    public function pushApplicant($data)
    {
        /*$data = [
            "term" => "202510",
            "idType" => "1",
            "id" => "1098765432",
            "gender" => "M",
            "birthDate" => "05/04/2000",
            "email" => "omar.khaled@domain.com",
            "phoneArea" => "966",
            "mobile" => "501234567",
            "citz" => "CZ",
            "nationality" => "SA",
            "firstNameAr" => "عمر",
            "fatherNameAr" => "خالد",
            "middleNameAr" => "فهد",
            "lastNameAr" => "القحطاني",
            "firstNameEn" => "Omar",
            "fatherNameEn" => "Khaled",
            "middleNameEn" => "Fahad",
            "lastNameEn" => "Al-Qahtani",
            "passport" => "A12345678",
            "passportExpiryDate" => "20/08/2030",
            "guardianFname" => "Khaled",
            "guardianMname" => "Fahad",
            "guardianLname" => "Al-Qahtani",
            "guardianPhoneArea" => "966",
            "guardianPhone" => "509876543",
            "priorColl" => "King Saud University",
            "priorDegree" => "BS",
            "priorMajor" => "Computer Science",
            "gpa" => "4.75",
            "maxGpa" => "5.0",
            "program" => "BSC-ACCT",
            "major" => "ACCT",
            "academicStatus" => "AS",
            "period" => "1",
            "enableMatch" => "N",
            "dateFormat" => "DD/MM/YYYY"
        ];*/

        return $this->sendRequest("push-applicant", $data);
    }

    public function pushPayments($data)
    {
        /*$data = [
            [
                "id" => "A00010565",
                "term" => "202510",
                "chargeCode" => "APPF",
                "amount" => 100,
                "paid" => true
            ],
            [
                "id" => "A00010565",
                "term" => "202510",
                "chargeCode" => "A04",
                "amount" => 2000,
                "paid" => true
            ],
            [
                "id" => "A00010565",
                "term" => "202510",
                "chargeCode" => "",
                "amount" => 25000,
                "paid" => true
            ]
        ];*/

        return $this->sendRequest("push-payments", $data);
    }
}



