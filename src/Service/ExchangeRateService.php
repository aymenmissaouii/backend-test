<?php
namespace Opeepl\BackendTest\Service;

/**
 * Main entrypoint for this library.
 */
class ExchangeRateService {

    /**
     * Return all supported currencies
     *
     * @return array<string>
     */
    public function getSupportedCurrencies(): array {

        $response = $this->getAmountApi(0,'','',"symbols");
        
        $decoderesopnse = json_decode($response, true);

        return array_keys($decoderesopnse['symbols']);
    }

    /**
     * Given the $amount in $fromCurrency, it returns the corresponding amount in $toCurrency.
     *
     * @param int $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return int
     */
    public function getExchangeAmount(int $amount, string $fromCurrency, string $toCurrency): int {

        $response = $this->getAmountApi($amount,$fromCurrency,$toCurrency,"convert?to={$toCurrency}&from={$fromCurrency}&amount={$amount}");
   
        $decoderesopnse = json_decode($response, true);
       
        return $decoderesopnse['result'];
    }


    public function getAmountApi(int $amount, string $fromCurrency, string $toCurrency, string $api): string{
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/{$api}",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            "apikey: l8oDcGxFWRsxX0W4GZGt7vbLiYLJUAHm"
          ),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET"
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return $response;
    }
}