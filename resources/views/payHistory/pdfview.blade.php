<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <b>{{__('labels.payment_uuid')}}:</b> ${{ $payHistory->getUuid() }}<br />
                        <b>{{__('labels.amount')}}:</b> ${{ $payHistory->getAmount() }}<br />
                        <b>{{__('labels.type')}}:</b> {{ $payHistory->getPaymentType() }}<br />
                        <b>{{__('labels.order')}}:</b> {{ $payHistory->getOrderId() }}<br />
                        <b>{{__('labels.status')}}:</b> {{ $payHistory->getPaymentStatus() }}<br />
                        <b>{{__('labels.date')}}:</b> {{ $payHistory->getPaymentDate() }}<br />
                        @if ($payHistory->getPaymentType() == "order")
                            <b>{{__('labels.codes')}}: </b><br />

                            <table class="table table-bordered">
                                <thead>
                                    <tr>  
                                        <th scope="col">{{__('labels.name')}}</th>
                                        <th scope="col">{{__('labels.code')}}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($payHistory->codes() as $code)
                                    <tr>
                                        <td>{{$code["name"]}}</td> 
                                        <td>{{$code["code"]}}</td>
                                    </tr>
                                    @empty
                                    <b>{{__('messages.no_codes')}}</b><br />
                                    @endforelse
                                </tbody>
                            </table>
                        @else
                            <b>{{__('labels.payment_method')}}:</b> {{ $payHistory->getPaymentMethod() }}<br />
                        @endif
                        
                        
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>