@extends('customer.account.layout')

@section('account')

    <div class="dsh-card">
        <div class="dsh-card-head"><h3>Edit Profile</h3></div>

        <div class="dsh-body">
            <form method="POST" action="{{ route('account.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="dsh-row">
                    <div class="dsh-f">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}">
                        @error('name')<span class="dsh-err">{{ $message }}</span>@enderror
                    </div>
                    <div class="dsh-f">
                        <label>Mobile Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $phone) }}" placeholder="01XXXXXXXXX">
                        @error('phone')<span class="dsh-err">{{ $message }}</span>@enderror
                    </div>
                    <div class="dsh-f">
                        <label>Email (verified)</label>
                        <input type="text" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="dsh-f">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($customer->date_of_birth)->format('Y-m-d')) }}">
                        @error('date_of_birth')<span class="dsh-err">{{ $message }}</span>@enderror
                    </div>
                    <div class="dsh-f">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Select</option>
                            @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $v => $l)
                                <option value="{{ $v }}" {{ old('gender', $customer->gender) === $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                        @error('gender')<span class="dsh-err">{{ $message }}</span>@enderror
                    </div>
                </div>

                <button type="submit" class="dsh-btn">Save Changes</button>
            </form>
        </div>
    </div>

@endsection