@extends('layouts.app')

@section('content')
<section class="container">
    <div class="card card-padded" style="padding: 20px;">
        <div id="msg"></div>
        <form id="card-form">
        @csrf
        <div class="card" style="padding: 25px; width:600px; margin-bottom: 10px;">
            <div id="card-element"></div>
        </div>
        <input type="hidden" name="plan_id" value="{{ $planId }}">
        <button class="btn btn-success" id="card-button" type="submit">Submit Payment</button>       
    </form>
    </div>
</section>
@endsection
@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    $( document ).ready(function() {
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");        
        var elements = stripe.elements();
        var cardElement = elements.create('card', {hidePostalCode: true},);
        cardElement.mount('#card-element');
        const form = document.getElementById('card-form');
        $(document).on('click', '#card-button', async function(event) {    
        $("#card-button").attr('disabled', true);
            event.preventDefault();
            const {token} = await stripe.createToken(cardElement);
            const plan_id = '1';                   
                    $.ajax({
                        type:'POST',
                        url:"{{ route('checkout.process') }}",
                        data:{"_token": "{{ csrf_token() }}","card_token": token.id, "plan_id": plan_id},
                        success:function(data){   
                            location.href = "{{ route('view.detail')}}"                            
                            // let getDate = data.subscription.trial_ends_at;
                            // let endDate  = new Date(getDate);
                            // let month = endDate.getMonth()+1;
                            // let year = endDate.getFullYear();
                            // let date  = endDate.getDate();    
                            // let fullDate = year+'-'+month+'-'+date;                            
                            // $('#msg').empty();
                            // $('#msg').append('<p>'+data.data.message +data.subscription.name +'. Your trial ends at '+fullDate+'</p>') 
                            // $('#card-form').hide();                            
                            $("#card-button").attr('disabled', false);
                        },
                        error: function(data){
                            alert(data.error);
                            console.log('hello');
                            $("#card-button").attr('disabled', false);
                        }
                    });
        });
    });
// trial ends on this date
</script>
@endpush