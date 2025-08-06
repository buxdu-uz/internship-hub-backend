<?php

namespace Database\Seeders;

use App\Models\University;
use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use GuzzleHttp\Psr7\Request;

class UniversitySeeder extends Seeder
{
    public mixed $client;

    public mixed $headers;

    public function __construct()
    {
        $this->clients = new Client();
        $this->headers = [
            'Authorization' => 'Bearer ' . config('hemis.api_key'),
            'Accept' => 'application/json',
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->university();
    }

    public function university()
    {
        $request = new Request('GET', config('hemis.host').'public/university-list', $this->headers);
        $res = $this->clients->sendAsync($request)->wait();
        $resBody = json_decode($res->getBody());

        foreach ($resBody->data as $item) {
            if (isset($item->api_url)){
                University::updateOrCreate([
                    'code' => $item->code,
                ], [
                    'name' => $item->name,
                    'api_url' => $item->api_url,
                    'student_url' => $item->student_url,
                    'employee_url' => $item->employee_url,
                ]);
            }
        }
    }
}
