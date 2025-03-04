<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlightController extends Controller
{
    public function search(Request $request)
    {
        $departure = $request->input('depart');
        $currentTime = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $realtime=Carbon::now('Asia/Ho_Chi_Minh');
        $request->validate([
            'to' => 'different:from',
            'depart' => 'after_or_equal:' . $currentTime,
            'return' => ['after_or_equal:' . $departure],
            'passenger' => ['required', 'numeric', 'min:1', 'max:4']
        ], [
            'to.different' => 'Airports can not be the same',
            'passenger.max' => 'Please contact us if you want to order more than 4 tickets',
            'return.after_or_equal' => 'The return day must be a date after or equal to departure day'
        ]);
        if ($request->class == "Economy") {
            $depart = $request->depart;
            $return = $request->return;
            $result = DB::table('flight as fli')
                ->join('airport as a', 'fli.FromPlace', '=', 'a.airport_code')
                ->join('airport as b', 'fli.ToPlace', '=', 'b.airport_code')
                ->join('plane as c', 'fli.planecode', '=', 'c.PlaneCode')
                ->join('seat_class as d', 'fli.flight_id', '=', 'd.Flight_id')
                ->select('a.city as fromcity', 'b.city as tocity', 'fli.*', 'c.PlaneName', 'd.price_class_PT as price', 'd.num_class_PT as seat')
                ->where('FromPlace', '=', $request->from)
                ->where('ToPlace', '=', $request->to)
                ->where('num_class_PT', '>=', $request->passenger)

                ->whereDate('departure', '=', $depart) 
                ->where('departure','>=',$realtime)
                ->orderBy('d.price_class_PT')	

                ->get();
            $class = $request->class;
            $passenger = $request->passenger;
            return view('flight-list', ['results' => $result, 'class' => $class, 'passenger' => $passenger, 'return' => $return]);
        } else {
            $depart = $request->depart;
            $return = $request->return;
            $result = DB::table('flight as fli')
                ->join('airport as a', 'fli.FromPlace', '=', 'a.airport_code')
                ->join('airport as b', 'fli.ToPlace', '=', 'b.airport_code')
                ->join('plane as c', 'fli.planecode', '=', 'c.PlaneCode')
                ->join('seat_class as d', 'fli.flight_id', '=', 'd.Flight_id')
                ->select('a.city as fromcity', 'b.city as tocity', 'fli.*', 'c.PlaneName', 'd.price_class_TG as price', 'd.num_class_TG as seat')
                ->where('FromPlace', '=', $request->from)
                ->where('ToPlace', '=', $request->to)
                ->where('num_class_TG', '>=', $request->passenger)
                ->whereDate('departure', '=', $depart)->where('departure','>=',$realtime)
                ->orderBy('d.price_class_TG')
                ->get();
            $class = $request->class;
            $passenger = $request->passenger;
            return view('flight-list', ['results' => $result, 'class' => $class, 'passenger' => $passenger, 'return' => $return]);
        }
    }

    public function booking(Request $request, $id)
    {
        $price1 = $request->input('price1');
        $price2 = $request->price2;
        $flightid1 = $request->flightid1;
        $flightid2 = $request->flightid2;
        $class = $request->class;
        $qty = $request->quantity;
        //  dd($qty);
        $depticket = DB::table('flight')
            ->where('flight_id', $flightid1)->first();
        $arrticket = DB::table('flight')
            ->where('flight_id', $flightid2)->first();
        return view('booking-details', ['depart' => $depticket, 'arri' => $arrticket, 'price1' => $price1, 'price2' => $price2, 'class' => $class, 'qty' => $qty]);
    }

    public function return(Request $request)
    {
        $realtime=Carbon::now('Asia/Ho_Chi_Minh');
        $from = $request->from;
        $to = $request->to;
        $depart = $request->departure;
        $class = $request->class;
        $passenger = $request->qty;
        $flightid1 = $request->flightid1;
        // dd($id1);
        if ($class == "Economy") {
            $result = DB::table('flight as fli')
                ->join('airport as a', 'fli.FromPlace', '=', 'a.airport_code')
                ->join('airport as b', 'fli.ToPlace', '=', 'b.airport_code')
                ->join('plane as c', 'fli.planecode', '=', 'c.PlaneCode')
                ->join('seat_class as d', 'fli.flight_id', '=', 'd.Flight_id')
                ->select('a.city as fromcity', 'b.city as tocity', 'fli.*', 'c.PlaneName', 'd.price_class_PT as price', 'd.num_class_PT as seat')
                ->where('FromPlace', '=', $from)
                ->where('ToPlace', '=', $to)
                ->where('num_class_PT', '>=', $passenger)
                ->whereDate('departure', '=', $depart)->where('departure','>=',$realtime)->orderBy('d.price_class_PT')
                ->get();
            //   dd($passenger);
            $price1 = $request->price;

            return view('flight-list-return', ['results' => $result, 'class' => $class, 'passenger' => $passenger, 'flightid1' => $flightid1, 'price1' => $price1]);
        } else {
            $result = DB::table('flight as fli')
                ->join('airport as a', 'fli.FromPlace', '=', 'a.airport_code')
                ->join('airport as b', 'fli.ToPlace', '=', 'b.airport_code')
                ->join('plane as c', 'fli.planecode', '=', 'c.PlaneCode')
                ->join('seat_class as d', 'fli.flight_id', '=', 'd.Flight_id')
                ->select('a.city as fromcity', 'b.city as tocity', 'fli.*', 'c.PlaneName', 'd.price_class_TG as price', 'd.num_class_TG as seat')
                ->where('FromPlace', '=', $from)
                ->where('ToPlace', '=', $to)
                ->where('num_class_TG', '>=', $passenger)

                ->whereDate('departure', '=', $depart)->where('departure','>=',$realtime) ->orderBy('d.price_class_TG')

                ->get();
            $price1 = $request->price;

            return view('flight-list-return', ['results' => $result, 'class' => $class, 'passenger' => $passenger, 'flightid1' => $flightid1, 'price1' => $price1]);
        }
    }



    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        // $productname = $request->get('productname');
        $email = $request->get('email');
        $customer_id = $request -> get('customerId');
        $totalprice = $request->get('totalprice');
        $rounded_totalprice = ceil($totalprice);
        $two0 = "00";
        $total = "$rounded_totalprice$two0";
        $quantity = $request->get('quantity');
        

        $session = \Stripe\Checkout\Session::create([
            'customer_email' => $email,
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'USD',
                        'product_data' => [
                            "name" => "Your Payout Amount",
                        ],
                        'unit_amount'  => $total,
                    ],
                    'quantity'   => 1,
                ],

            ],
            'mode'        => 'payment',
            'success_url' => route('success'),
            'cancel_url'  => route('checkout'),
        ]);

        // $status = $session->payment_status;
        $status = 'paid';
        $paymentMethod = $session->payment_method_types[0];

        DB::table('order')->insert([
            'customer_id' => $customer_id,
            'quantity' => $quantity,
            'total_price' => $totalprice,
            'status' => $status,
            'paymentmethod' => $paymentMethod,
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {
        return view('thank');
    }
    public function processBooking(Request $request)
    {
        $totalprice = $request->totalprice;
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $gender = $request->input('gender');
        $quantity = $request->quantity;
        $totalquantity = $quantity * 2;
        $price1 = $request->price1;
        $price2 = $request->price2;
        $class = $request->class;
        $flightid1 = $request->flightid1;
        $flightid2 = $request->flightid2;
        //  dd($quantity,$price1,$price2,$class,$flightid1,$flightid2);
        if (Auth::check()) {
            $customerId = DB::table('customer')->insertGetId([
                'AccountId' => Auth::id(),
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'email' => $email,
                'gender' => $gender
            ]);
            // dd($customerId);
            for ($i = 1; $i <= $quantity; $i++) {
                $depticket = DB::table('ticket')->insert([
                    'flight_id' => $flightid1,
                    'Customer_id' => $customerId,
                    'type' => $class,
                    'price' => $price1,
                    'pass_firstname' => $request->pass_firstname[$i],
                    'pass_lastname' => $request->pass_lastname[$i],
                    'pass_gender' => $request->pass_gender[$i],
                    'pass_dob' => Carbon::parse($request->birthday[$i])->format('Y-m-d'),
                    'pass_cmnd' => $request->passport[$i],
                ]);

                $arrticket = DB::table('ticket')->insert([
                    'flight_id' => $flightid2,
                    'Customer_id' => $customerId,
                    'type' => $class,
                    'price' => $price2,
                    'pass_firstname' => $request->pass_firstname[$i],
                    'pass_lastname' => $request->pass_lastname[$i],
                    'pass_gender' => $request->pass_gender[$i],
                    'pass_dob' => Carbon::parse($request->birthday[$i])->format('Y-m-d'),
                    'pass_cmnd' => $request->passport[$i],
                ]);

                if ($class == "Economy") {
                    $rs1 = DB::table('seat_class')->where('flight_id', $flightid1)->first();
                    $rs2 = DB::table('seat_class')->where('flight_id', $flightid2)->first();
                    DB::table('seat_class')->where('flight_id', $flightid1)
                        ->update([
                            'num_class_PT' => $rs1->num_class_PT - 1
                        ]);
                    DB::table('seat_class')->where('flight_id', $flightid2)
                        ->update([
                            'num_class_PT' => $rs2->num_class_PT - 1
                        ]);
                } else {
                    $rs1 = DB::table('seat_class')->where('flight_id', $flightid1)->first();
                    $rs2 = DB::table('seat_class')->where('flight_id', $flightid2)->first();
                    DB::table('seat_class')->where('flight_id', $flightid1)
                        ->update([
                            'num_class_TG' => $rs1->num_class_TG - 1
                        ]);
                    DB::table('seat_class')->where('flight_id', $flightid2)
                        ->update([
                            'num_class_TG' => $rs2->num_class_TG - 1
                        ]);
                }
            }
            $ticket = DB::table('ticket')->where('Customer_id', $customerId)->get();
            //  dd($depticket);
            return view('confirmation', ['quantity' => $totalquantity, 'customer_id' => $customerId, 'total_price' => $totalprice, 'ticket' => $ticket]);
        } else {
            $customerId = DB::table('customer')->insertGetId([
                // 'AccountId' => Auth()->user()->id,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'email' => $email,
                'gender' => $gender
            ]);
            for ($i = 1; $i <= $quantity; $i++) {
                $depticket = DB::table('ticket')->insert([
                    'flight_id' => $flightid1,
                    'Customer_id' => $customerId,
                    'type' => $class,
                    'price' => $price1,
                    'pass_firstname' => $request->pass_firstname[$i],
                    'pass_lastname' => $request->pass_lastname[$i],
                    'pass_gender' => $request->pass_gender[$i],
                    'pass_dob' => Carbon::parse($request->birthday[$i])->format('Y-m-d'),
                    'pass_cmnd' => $request->passport[$i],
                ]);

                $arrticket = DB::table('ticket')->insert([
                    'flight_id' => $flightid2,
                    'Customer_id' => $customerId,
                    'type' => $class,
                    'price' => $price2,
                    'pass_firstname' => $request->pass_firstname[$i],
                    'pass_lastname' => $request->pass_lastname[$i],
                    'pass_gender' => $request->pass_gender[$i],
                    'pass_dob' => Carbon::parse($request->birthday[$i])->format('Y-m-d'),
                    'pass_cmnd' => $request->passport[$i],
                ]);

                if ($class == "Economy") {
                    $rs1 = DB::table('seat_class')->where('flight_id', $flightid1)->first();
                    $rs2 = DB::table('seat_class')->where('flight_id', $flightid2)->first();
                    DB::table('seat_class')->where('flight_id', $flightid1)
                        ->update([
                            'num_class_PT' => $rs1->num_class_PT - 1
                        ]);
                    DB::table('seat_class')->where('flight_id', $flightid2)
                        ->update([
                            'num_class_PT' => $rs2->num_class_PT - 1
                        ]);
                } else {
                    $rs1 = DB::table('seat_class')->where('flight_id', $flightid1)->first();
                    $rs2 = DB::table('seat_class')->where('flight_id', $flightid2)->first();
                    DB::table('seat_class')->where('flight_id', $flightid1)
                        ->update([
                            'num_class_TG' => $rs1->num_class_TG - 1
                        ]);
                    DB::table('seat_class')->where('flight_id', $flightid2)
                        ->update([
                            'num_class_TG' => $rs2->num_class_TG - 1
                        ]);
                }
                $ticket = DB::table('ticket')->where('Customer_id', $customerId)->get();
            }
            return view('confirmation', ['quantity' => $totalquantity, 'customer_id' => $customerId, 'total_price' => $totalprice, 'ticket' => $ticket]);
        }

        // $flight_id = $request->input('flight_id');
        // $class = $request->input('class');
        // $qty = $request->input('qty');
        // $price = $request->input('price');
        // $total = $qty * $price;

        // $bookingId = DB::table('booking')->insertGetId([
        //     'flight_id' => $flight_id,
        //     'customer_id' => $customerId,
        //     'class' => $class,
        //     'qty' => $qty,
        //     'total' => $total
        // ]);
        // return redirect()->route('confirmation', ['id' => $bookingId]);
    }


    // public function order_addprocess(Request $request)
    // {
    //     $request->validate([
    //         'customer_id' => 'required',
    //         'quantity' => 'required|numeric',
    //         'total_price' => 'required|numeric',
    //         'status' => 'required',
    //         'paymentmethod' => 'required',
    //         'firstname' => 'required',
    //         'lastname' => 'required',
    //         'gender' => 'required', 
    //         'phone' => 'required', 
    //         'birthday' => 'required', 
    //         'email' => 'required|email', 

    //         'pass_firstname.*' => 'required',
    //         'pass_lastname.*' => 'required',
    //         'pass_gender.*' => 'required',
    //         'birthday.*' => 'required',
    //         'passport.*' => 'required',
    //     ]);
    //     DB:table('customer')->insert([

    //     ])





    //     return redirect()->route('order')->with('message', 'Order added successfully!');
    // }
}
