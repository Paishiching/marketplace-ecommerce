@extends('customer.account.layout')

@section('account')

    <div class="dsh-card">
        <div class="dsh-card-head">
            <h3>Saved Addresses</h3>
            <a href="{{ route('checkout.index') }}">+ Add at checkout</a>
        </div>

        <div class="dsh-body">
            @if($addresses->count())
                <div class="dsh-addr-grid">
                    @foreach($addresses as $addr)
                        <div class="dsh-addr">
                            <strong>{{ $addr->recipient_name ?: 'N/A' }}</strong>
                            <span>{{ $addr->address_line1 }}</span>
                            @if($addr->address_line2)<span>{{ $addr->address_line2 }}</span>@endif
                            <span>{{ $addr->city }}</span>
                            @if($addr->state)<span>{{ $addr->state }}</span>@endif
                            <span>{{ $addr->phone }}</span>

                            <div class="d-flex gap-2 mt-2"><a class="dsh-view" href="{{ route('account.addresses.edit', $addr->id) }}">Edit address</a>
                                <form method="POST" action="{{ route('account.addresses.destroy', $addr->id) }}" onsubmit="return confirm('Delete this address?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="dsh-del">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="dsh-empty" style="padding:30px 0">
                    <p>Kono saved address nai. Checkout er somoy address save korle ekhane dekhabe.</p>
                </div>
            @endif
        </div>
    </div>

@endsection
