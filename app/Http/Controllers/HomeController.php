<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    private $APP_API_URL;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->APP_API_URL = env('APP_API_URL');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $page = $request->get('page');
        $id = $request->get('id');

        $token = $request->session()->get("auth.bearer_token");
        if ($token == null)  {
            $loginData = Http::withHeaders([
                    "Accept"=> "application/json",
                ])
                ->get($this->APP_API_URL . '/auth/login',[
                    'email' => 'claudiorhessel@gmail.com',
                    'password' => 'claudio@123'
                ]);

                if ($loginData->json()['token']) {
                    $token = $loginData->json()['token'];
                }

                $request->session()->put('auth.bearer_token', $token);
        }

        $customersData = Http::withHeaders([
                "Accept"=> "application/json",
                "Authorization" => "Bearer " . $token
            ])
            ->get($this->APP_API_URL . '/customer',[
                'page' => $request->get('page'),
                'birtdate' => $request->get('birtdate'),
                'full_name' => $request->get('full_name'),
                'cpf' => $request->get('cpf'),
                'gender' => $request->get('gender'),
                'address' => $request->get('address'),
                'state_id' => $request->get('state_id'),
                'city_id' => $request->get('city_id')
            ]);

        if ($id) {
            $customerData = Http::withHeaders([
                    "Accept"=> "application/json",
                    "Authorization" => "Bearer " . $token
                ])
                ->get($this->APP_API_URL . '/customer/' . $id);
        }

        $stateData = $this->getStates($request);
        $cityData = $this->getCities($request);

        $customers = $customersData->json()["data"];
        $customers['state'] = $stateData->json()["data"];
        $customers['city'] = $cityData->json()["data"];
        $customers['id'] = $request->get('id');
        $customers['currentCustomer'] = $request->all();

        $customerRequesteReturn = $request->get('customerError');
        if (isset($customerRequesteReturn['status']) && !$customerRequesteReturn['status']) {
            $customers['currentCustomer'] = $request->all()['currentCustomer'];
            $customers['route'] = $request->get('route');
            $customers['method'] =$request->get('method');
            return view('home', $customers);
        }

        $customers['route'] = $request->get('route', 'home');
        $customers['method'] = $request->get('method', 'GET');

        if (isset($customerData)) {
            $customers['currentCustomer'] = [
                "id" => $customerData->json()["data"]["id"],
                "cpf" => $customerData->json()["data"]["cpf"],
                "full_name" => $customerData->json()["data"]["full_name"],
                "birtdate" => $customerData->json()["data"]["birtdate"],
                "gender" => $customerData->json()["data"]["gender"],
                "address" => $customerData->json()["data"]["address"]["address"],
                "city_id" => $customerData->json()["data"]["address"]["city_id"],
                "state_id" => $customerData->json()["data"]["address"]["state_id"]
            ];
        }

        return view('home', $customers);
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        $token = $request->session()->get("auth.bearer_token");
        $customerData = Http::withHeaders([
                "Accept"=> "application/json",
                "Authorization" => "Bearer " . $token
            ])
            ->put($this->APP_API_URL . "/customer/" . $id, $request->all());

        $returnData['currentCustomer'] = $request->all();
        $returnData['customerError'] = $customerData->json();
        $returnData['route'] = 'customerEdit';
        $returnData['method'] = 'POST';

        if (isset($customerData->json()['status']) && $customerData->json()['status']) {
            $addressDataToInsert = $request->all();
            $addressDataToInsert['customer_id'] = $customerData->json()['data']['id'];

            if (isset($customerData->json()['data']['address']['id'])) {
                $addressData = Http::withHeaders([
                        "Accept"=> "application/json",
                        "Authorization" => "Bearer " . $token
                    ])
                    ->put($this->APP_API_URL . "/address/" . $customerData->json()['data']['address']['id'], $addressDataToInsert);
            } else {
                $addressData = Http::withHeaders([
                        "Accept"=> "application/json",
                        "Authorization" => "Bearer " . $token
                    ])
                    ->post($this->APP_API_URL . "/address/", $addressDataToInsert);
            }

            if ($addressData->json()['status']) {
                return redirect()->route('home', $customerData->json())
                    ->with('message', 'Success');
            }
        }

        return redirect()->route('home', $returnData)
            ->with('message', $returnData['customerError']['message'])
            ->withErrors($returnData['customerError']['errors']);
    }

    public function insert(Request $request)
    {
        $token = $request->session()->get("auth.bearer_token");
        $customerData = Http::withHeaders([
                "Accept"=> "application/json",
                "Authorization" => "Bearer " . $token
            ])
            ->post($this->APP_API_URL . "/customer/", $request->all());

        $returnData['currentCustomer'] = $request->all();
        $returnData['customerError'] = $customerData->json();
        $returnData['route'] = 'customerInsert';
        $returnData['method'] = 'POST';

        if (isset($customerData->json()['status']) && $customerData->json()['status']) {
            $addressDataToInsert = $request->all();
            $addressDataToInsert['customer_id'] = $customerData->json()['data']['id'];

            $addressData = Http::withHeaders([
                    "Accept"=> "application/json",
                    "Authorization" => "Bearer " . $token
                ])
                ->post($this->APP_API_URL . "/address/", $addressDataToInsert);

            if (isset($addressData->json()['status']) && $addressData->json()['status']) {
                return redirect()->route('home', $customerData->json())
                    ->with('message', 'Success');
            }

            $returnData['currentCustomer'] = $request->all();
            $returnData['addressError'] = $addressData->json();

            return redirect()->route('home', $returnData)
                ->with('message', $returnData['addressError']['message'])
                ->withErrors($returnData['addressError']['errors']);
        }

        return redirect()->route('home', $returnData)
            ->with('message', $returnData['customerError']['message'])
            ->withErrors($returnData['customerError']['errors']);
    }

    public function remove(Request $request)
    {
        $id = $request->get('id');
        $token = $request->session()->get("auth.bearer_token");
        $customerData = Http::withHeaders([
                "Accept"=> "application/json",
                "Authorization" => "Bearer " . $token
            ])
            ->delete($this->APP_API_URL . "/customer/" . $id);

        return $this->home($request);
    }

    private function getStates(Request $request)
    {
        $token = $request->session()->get("auth.bearer_token");

        return Http::withHeaders([
            "Accept"=> "application/json",
            "Authorization" => "Bearer " . $token
        ])
        ->get($this->APP_API_URL . '/state');

    }

    private function getCities(Request $request)
    {
        $token = $request->session()->get("auth.bearer_token");

        return Http::withHeaders([
            "Accept"=> "application/json",
            "Authorization" => "Bearer " . $token
        ])
        ->get($this->APP_API_URL . '/city');
    }
}
