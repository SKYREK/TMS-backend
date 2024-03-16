<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;

class PaymentController extends Controller
{
    //create payment
    public function createPayment(Request $request){
        //validate
        try{
            $request->validate([
                'booking_id' => 'required',
                'amount' => 'required',
                'date' => 'required',
                'card_number' => 'required',
                'card_holder_name' => 'required',
                'card_expiry_date' => 'required',
                'card_cvv' => 'required'
            ]);
            //get relavane booking
            $booking = Booking::find($request->booking_id);
            //set booking status to paid
            $booking->payment_status = 'paid';
            $booking->save();
            return Payment::create($request->all());
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    //get payment by booking id
    public function getPayment($booking_id){
        return Payment::where('booking_id', $booking_id)->first();
    }
    //get payments by username of booking
    public function getPayments($username){
        return Payment::join('bookings', 'payments.booking_id', '=', 'bookings.id')
        ->where('bookings.username', $username)
        ->get();
    }
}
