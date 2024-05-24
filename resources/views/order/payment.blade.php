@extends('templates.base')

@section('content')

<div class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">

    <div id="rzp_checkout"></div>
    <form action="{{ route('order.store') }}" method="post" class="mt-6 flex justify-center">
        @csrf
        <button type="submit" class="w-1/3 flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">
            Pay&nbsp;{{number_format($data['amount'])}}
        </button>
    </form>

</div>




<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>

function paymentOkHandler(response) {
    console.log(response)
    /**
     * The entire list of Checkout fields is available at
     * https://docs.razorpay.com/docs/checkout-form#checkout-fields
     */
    console.log("Payment was successful");
    paymentData.razorpay_order_id      = response.razorpay_order_id;
    paymentData.razorpay_payment_id    = response.razorpay_payment_id;
    paymentData.razorpay_signature     = response.razorpay_signature;


    console.log(paymentData);

    const url = "/payment/store";
    axios.post(url, paymentData).then(paymentSuccessfulHandler).catch(paymentFailureHandler);

};

function paymentSuccessfulHandler() {
    // redirect to success page
    window.location = "/order/success";
}

function paymentFailureHandler() {
    // redirect to failure page
    window.location = "/order/failure";
}


const options = @php echo json_encode($data) @endphp;
const paymentData = {};

options.handler = paymentOkHandler;

// $data = [ "key" => "razorpay_key", "amount" => 800000 ];
// json_encode($data)
// { "key": "razorpay_key", "amount": 800000 };

// const rzp = document.querySelector
const rzp = new Razorpay(options);
rzp.open();

</script>

@endSection
