@extends(auth()->user()->hasRole('superadmin') ? 'layouts.superadmin.panel' : 'layouts.admin.app')
@section('title', 'New Order')
@section('panel_content')
@php($ordersIndexRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.manual-orders.index' : 'admin.orders.orders.index')
@php($ordersStoreRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.manual-orders.store' : 'admin.orders.orders.store')
<style>
    .manual-order{--mo-orange:#fd6801;--mo-navy:#2a3582}.manual-order .card{border:0;border-radius:14px;box-shadow:0 5px 24px rgba(42,53,130,.08)}
    .manual-order .section-title{font-weight:700;color:var(--mo-navy)}.manual-order .form-label{font-weight:600;color:#38416f}
    .manual-order .form-control,.manual-order .form-select{min-height:44px;border-color:#dfe3f0;border-radius:9px}
    .manual-order .btn-primary{background:var(--mo-orange);border-color:var(--mo-orange)}.manual-order .btn-primary:hover{background:#e95d00;border-color:#e95d00}
    .manual-order .party-card{background:#f5f7ff;border:1px solid #e6e9f5;border-radius:12px;padding:16px}
    .manual-order .party-number{color:var(--mo-orange);font-weight:700}.manual-order .table thead th{white-space:nowrap;color:var(--mo-navy)}
    .manual-order .line-input{min-width:86px;max-width:130px}.manual-order .grand-total{font-size:20px;font-weight:800;color:var(--mo-navy)}
</style>
<div class="manual-order">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div><h3 class="mb-1">New Order Form</h3><p class="text-muted mb-0">Choose a customer, add products and review the total.</p></div>
        <a href="{{ route($ordersIndexRoute) }}" class="btn btn-outline-secondary">Back to orders</a>
    </div>
    @if($errors->any())<div class="alert alert-danger"><strong>Please check the form:</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route($ordersStoreRoute) }}" id="manualOrderForm">
        @csrf
        <div class="card mb-3"><div class="card-body p-4">
            <h5 class="section-title mb-3">Customer / Party</h5>
            <div class="row g-3 align-items-end">
                <div class="col-lg-5"><label class="form-label" for="customerSearch">Find customer</label><input class="form-control" id="customerSearch" type="search" placeholder="Search by name, phone or email"></div>
                <div class="col-lg-7"><label class="form-label" for="customerSelect">Customer <span class="text-danger">*</span></label>
                    <select class="form-select" name="customer_id" id="customerSelect" required>
                        <option value="">Select a customer</option>
                        @foreach($customers as $customer)
                            @php($user = $customer->user)
                            <option value="{{ $customer->id }}" data-name="{{ $user->name }}" data-phone="{{ $user->phone }}" data-email="{{ $user->email }}" data-search="{{ strtolower($customer->id.' '.$user->name.' '.$user->phone.' '.$user->email) }}" @selected(old('customer_id') == $customer->id)>
                                Party #{{ $customer->id }} · {{ $user->name }} · {{ $user->phone ?: $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="party-card mt-3" id="partyCard" hidden>
                <div class="row g-3"><div class="col-sm-3"><div class="small text-muted">Party number</div><div class="party-number" id="partyNumber">—</div></div>
                    <div class="col-sm-4"><div class="small text-muted">Name</div><strong id="partyName">—</strong></div>
                    <div class="col-sm-5"><div class="small text-muted">Contact</div><span id="partyContact">—</span></div></div>
            </div>
            <div class="row g-3 mt-1"><div class="col-md-4"><label class="form-label">Order name</label><input class="form-control" name="name" id="orderName" value="{{ old('name') }}" maxlength="150" required></div>
                <div class="col-md-4"><label class="form-label">Mobile number</label><input class="form-control" name="phone" id="orderPhone" value="{{ old('phone') }}" maxlength="20" required></div>
                <div class="col-md-4"><label class="form-label">Email <span class="text-muted fw-normal">(optional)</span></label><input class="form-control" type="email" name="email" id="orderEmail" value="{{ old('email') }}" maxlength="150"></div></div>
        </div></div>

        <div class="card mb-3"><div class="card-body p-4">
            <h5 class="section-title mb-3">Add products</h5>
            <div class="row g-3 align-items-end">
                <div class="col-lg-6"><label class="form-label" for="productSelect">Model / product</label><select class="form-select" id="productSelect"><option value="">Select model</option>
                    @foreach($products as $product)@php($unitPrice = $product->discount_price > 0 ? $product->discount_price : $product->price)
                        <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-sku="{{ $product->sku }}" data-price="{{ $unitPrice }}">{{ $product->name }}{{ $product->sku ? ' · '.$product->sku : '' }}</option>
                    @endforeach
                </select></div>
                <div class="col-6 col-lg-2"><label class="form-label" for="lineQuantity">Quantity</label><input class="form-control" type="number" min="1" step="1" id="lineQuantity" value="1"></div>
                <div class="col-6 col-lg-2"><label class="form-label" for="linePrice">Unit price (৳)</label><input class="form-control" type="number" min="0" step="0.01" id="linePrice" placeholder="0.00"></div>
                <div class="col-12 col-lg-2"><button type="button" class="btn btn-primary w-100" id="addItem"><i class="bx bx-plus-circle"></i> Add item</button></div>
            </div>
        </div></div>

        <div class="card mb-3"><div class="card-body p-4">
            <h5 class="section-title mb-3">Order items</h5><div class="table-responsive"><table class="table align-middle" id="itemsTable">
                <thead><tr><th>Product / model</th><th>Quantity</th><th>Unit price</th><th>Line total</th><th></th></tr></thead>
                <tbody id="itemsBody"><tr id="emptyRow"><td colspan="5" class="text-center text-muted py-4">No products added yet.</td></tr></tbody>
            </table></div>
            <div class="d-flex justify-content-end border-top pt-3"><div class="grand-total">Total amount: ৳ <span id="grandTotal">0.00</span></div></div>
            <div class="mt-3"><label class="form-label" for="orderNotes">Order note <span class="text-muted fw-normal">(optional)</span></label><textarea class="form-control" name="notes" id="orderNotes" rows="2" maxlength="2000" placeholder="Add delivery or customer instructions">{{ old('notes') }}</textarea></div>
        </div></div>
        <div class="d-flex flex-wrap justify-content-end gap-2"><a href="{{ route($ordersIndexRoute) }}" class="btn btn-outline-secondary px-4">Cancel</a><button type="submit" class="btn btn-primary px-4" id="submitOrder" disabled>Create order</button></div>
    </form>
</div>
<script>
(() => {
    const customerSelect=document.getElementById('customerSelect'), customerSearch=document.getElementById('customerSearch');
    const productSelect=document.getElementById('productSelect'), quantityInput=document.getElementById('lineQuantity'), priceInput=document.getElementById('linePrice');
    const state=new Map();
    const escapeHtml=(value)=>String(value??'').replace(/[&<>"']/g,ch=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[ch]));
    function chooseCustomer(){const option=customerSelect.selectedOptions[0], card=document.getElementById('partyCard'); if(!option?.value){card.hidden=true;return;} card.hidden=false;
        document.getElementById('partyNumber').textContent='#'+option.value; document.getElementById('partyName').textContent=option.dataset.name||'Customer';
        document.getElementById('partyContact').textContent=[option.dataset.phone,option.dataset.email].filter(Boolean).join(' · ')||'No contact details';
        document.getElementById('orderName').value=option.dataset.name||''; document.getElementById('orderPhone').value=option.dataset.phone||''; document.getElementById('orderEmail').value=option.dataset.email||'';
    }
    customerSelect.addEventListener('change',chooseCustomer);
    customerSearch.addEventListener('input',()=>{const term=customerSearch.value.trim().toLowerCase(); Array.from(customerSelect.options).forEach((option,index)=>{if(index===0)return;option.hidden=term!==''&&!option.dataset.search.includes(term);}); if(customerSelect.selectedOptions[0]?.hidden)customerSelect.value='';});
    productSelect.addEventListener('change',()=>{const option=productSelect.selectedOptions[0]; priceInput.value=option?.dataset.price||'';});
    function render(){const body=document.getElementById('itemsBody'), rows=Array.from(state.values()); body.innerHTML='';
        if(!rows.length) body.innerHTML='<tr><td colspan="5" class="text-center text-muted py-4">No products added yet.</td></tr>';
        rows.forEach((item,index)=>{const line=item.quantity*item.unitPrice;const tr=document.createElement('tr');
            tr.innerHTML='<td><strong>'+escapeHtml(item.name)+'</strong>'+(item.sku?'<div class="small text-muted">'+escapeHtml(item.sku)+'</div>':'')+'<input type="hidden" name="items['+index+'][product_id]" value="'+item.id+'"></td>'+
                '<td><input class="form-control form-control-sm line-input item-quantity" type="number" min="1" step="1" name="items['+index+'][quantity]" value="'+item.quantity+'" aria-label="Quantity for '+escapeHtml(item.name)+'"></td>'+
                '<td><input class="form-control form-control-sm line-input item-price" type="number" min="0" step="0.01" name="items['+index+'][unit_price]" value="'+item.unitPrice.toFixed(2)+'" aria-label="Unit price for '+escapeHtml(item.name)+'"></td>'+
                '<td class="fw-semibold">৳ '+line.toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2})+'</td><td><button type="button" class="btn btn-sm btn-outline-danger remove-item" aria-label="Remove '+escapeHtml(item.name)+'"><i class="bx bx-trash"></i></button></td>';
            tr.querySelector('.item-quantity').addEventListener('change',e=>{item.quantity=Math.max(1,parseInt(e.target.value||'1',10));render();});
            tr.querySelector('.item-price').addEventListener('change',e=>{item.unitPrice=Math.max(0,parseFloat(e.target.value||'0'));render();});
            tr.querySelector('.remove-item').addEventListener('click',()=>{state.delete(item.id);render();}); body.appendChild(tr);
        });
        const total=rows.reduce((sum,item)=>sum+item.quantity*item.unitPrice,0);document.getElementById('grandTotal').textContent=total.toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2});document.getElementById('submitOrder').disabled=!rows.length;
    }
    document.getElementById('addItem').addEventListener('click',()=>{const option=productSelect.selectedOptions[0],quantity=parseInt(quantityInput.value||'0',10),unitPrice=parseFloat(priceInput.value);
        if(!option?.value){productSelect.focus();return;}if(quantity<1||!Number.isFinite(quantity)){quantityInput.focus();return;}if(!Number.isFinite(unitPrice)||unitPrice<0){priceInput.focus();return;}
        state.set(option.value,{id:option.value,name:option.dataset.name,sku:option.dataset.sku,quantity,unitPrice});productSelect.value='';quantityInput.value='1';priceInput.value='';render();
    });
    if(customerSelect.value)chooseCustomer(); render();
})();
</script>
@endsection
