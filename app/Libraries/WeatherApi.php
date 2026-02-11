<?php

namespace App\Libraries;

use Config\Services;

class WeatherApi
{
    // 멤버 변수 정의
    protected $accessKey;
    protected $secretKey;
    protected $vendorid;
    protected $httpClient;

    protected $apiAuthKey = "Ilbn7eBsSWWW5-3gbAlltA";
    protected $apiUrl = "https://apihub.kma.go.kr/api";

    public function __construct()
    {
        $this->httpClient = Services::curlrequest();
    }

    /**
     * 특정 지점의 날씨 데이터 가져오기
     */
    public function getAsosData(string $stn, string $tm = null): ?array
    {
        $tm = $tm ?? date('YmdH00');
        $path = "/typ01/url/kma_sfctm2.php";
        $url = $this->apiUrl . $path ;
        try {
            $response = $this->httpClient->get($url, [
                'query' => [
                    'tm'      => $tm,
                    'stn'     => $stn,
                    'help'    => '1',
                    'authKey' => $this->apiAuthKey // 기상청 전용 키
                ],
                'timeout' => 5
            ]);
            return $this->parse($response->getBody());
        } catch (\Exception $e) {
            log_message('error', '[KMA API Error] ' . $e->getMessage());
            return null;
        }
    }

    private function parse(string $body): ?array
    {
        // #START7777 등의 불필요한 태그가 섞여 있을 수 있으므로 실제 데이터 시작점 찾기
        $lines = explode("\n", trim($body));
        $columns = [];
        $data = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || $line === '#7777END' || $line === '#START7777') continue;

            // 1. 컬럼 헤더 추출 (올려주신 데이터는 YYMMDDHHMI로 시작함)
            if (strpos($line, '# YYMMDDHHMI') === 0) {
                $clean_header = ltrim($line, '# ');
                $columns = preg_split('/\s+/', $clean_header);
                continue;
            }

            // 2. 단위나 설명 줄 (# KST ID 16...) 은 건너뛰기
            if (strpos($line, '#') === 0) {
                continue;
            }

            // 3. 실제 데이터 파싱
            $values = preg_split('/\s+/', $line);

            // 컬럼 개수와 데이터 개수가 맞지 않는 경우를 대비한 유연한 결합
            if (!empty($columns) && !empty($values)) {
                // 개수가 맞지 않으면 데이터 개수만큼만 잘라서 매칭 (방어적 코딩)
                $count = min(count($columns), count($values));
                $mappedData = [];
                for ($i = 0; $i < $count; $i++) {
                    $mappedData[$columns[$i]] = $values[$i];
                }
                return $mappedData;
            }
        }

        return null;
    }

}