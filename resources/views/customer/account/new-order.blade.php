@extends('customer.account.layout')

@section('account')
<style>
    .new-order{--no-navy:#24347f;--no-orange:#ff6900;color:#26345e}
    .new-order .no-panel{background:#fff;border:1px solid #e8edf6;border-radius:18px;box-shadow:0 8px 26px rgba(22,43,91,.06);padding:22px;margin-bottom:18px}
    .new-order .no-title{color:var(--no-navy);font-size:20px;font-weight:800;margin:0 0 5px}
    .new-order .no-muted{color:#718096}
    .new-order .form-control,.new-order .form-select{min-height:46px;border-radius:10px;border-color:#dce3ef}
    .new-order .btn-primary{background:var(--no-orange);border-color:var(--no-orange);border-radius:9px}
    .new-order .no-party{border-radius:14px;background:linear-gradient(120deg,#273882,#4169d8);padding:18px;color:#fff}
    .new-order .no-party small{display:block;color:#d7e2ff;font-weight:600}.new-order .no-party strong{display:block;font-size:18px;overflow-wrap:anywhere}
    .new-order .no-selection{background:#f7f8fc;border-radius:12px;padding:14px}.new-order input[readonly]{background:#f4f6fa}
    .new-order .no-dropdown{position:absolute;top:100%;left:0;right:0;max-height:320px;overflow:auto;z-index:20;box-shadow:0 12px 28px rgba(20,35,75,.16);border:1px solid #e5eaf3;border-radius:0 0 12px 12px}
    .new-order .no-product-option{display:flex;gap:12px;align-items:center;white-space:normal;padding:10px 12px}
    .new-order .no-product-option img{width:58px;height:58px;flex:0 0 58px;object-fit:contain;border-radius:8px;background:#f5f6f8}
    .new-order .no-price{font-weight:800;color:var(--no-navy)}
    .new-order .no-line{border:1px solid #e7ebf3;border-radius:13px;padding:14px;margin-bottom:10px}
    .new-order .no-line:last-child{margin-bottom:0}.new-order .no-line-title{font-weight:750;color:#253579;overflow-wrap:anywhere}
    .new-order .no-total{font-size:21px;font-weight:850;color:var(--no-navy)}
    .new-order .no-empty{border:1px dashed #cfd7e7;border-radius:12px;color:#77839a;text-align:center;padding:28px 16px}
    .new-order .no-action{min-width:78px}.new-order .no-submit{display:flex;justify-content:flex-end;gap:10px}
    @media(max-width:575.98px){.new-order .no-panel{padding:16px;border-radius:14px}.new-order .no-submit{position:sticky;bottom:12px;z-index:4;background:#fff;padding:10px;border:1px solid #e7ebf3;border-radius:12px;box-shadow:0 8px 20px #14213d1f}.new-order .no-total{font-size:19px}}
</style>

<div class="new-order">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div><h2 class="no-title">New Order Form</h2><p class="no-muted mb-0">Choose products and quantity, then confirm delivery and payment at checkout.</p></div>
        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">Back to dashboard</a>
    </div>
    @if($errors->any())<div class="alert alert-danger"><strong>Please check your order:</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <form method="POST" action="{{ route('customer.new-order.store') }}" id="customerOrderForm">
        @csrf
        <section class="no-panel">
            <h3 class="no-title">Customer / Party</h3>
            <div class="no-party row g-3 align-items-center mt-2">
                <div class="col-5 col-sm-4"><small>Party Number</small><strong>#{{ $customer->id }}</strong></div>
                <div class="col-7 col-sm-8"><small>Name</small><strong>{{ $user->name ?: 'Customer' }}</strong></div>
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-4"><label class="form-label" for="customerName">Order name</label><input class="form-control" id="customerName" name="name" value="{{ old('name', $user->name) }}" maxlength="150" required></div>
                <div class="col-md-4"><label class="form-label" for="customerPhone">Mobile number</label><input class="form-control" id="customerPhone" name="phone" value="{{ old('phone', $phone) }}" maxlength="20" inputmode="tel" required></div>
                <div class="col-md-4"><label class="form-label" for="customerEmail">Email <span class="text-muted">(optional)</span></label><input class="form-control" type="email" id="customerEmail" name="email" value="{{ old('email', $user->email) }}" maxlength="150"></div>
            </div>
            <div class="row g-3 mt-1 align-items-end">
                <div class="col-md-8"><label class="form-label" for="shippingAddress">Delivery address</label><select class="form-select" name="shipping_address_id" id="shippingAddress"><option value="">Select a saved address (optional)</option>@foreach($addresses as $address)<option value="{{ $address->id }}" @selected(old('shipping_address_id') == $address->id)>{{ $address->recipient_name }} · {{ $address->address_line1 }}, {{ $address->city }} · {{ $address->phone }}</option>@endforeach</select></div>
                <div class="col-md-4"><a href="{{ route('account.addresses') }}" class="btn btn-outline-primary w-100">Manage saved addresses</a></div>
            </div>
        </section>

        <section class="no-panel">
            <h3 class="no-title">Add product</h3>
            <p class="no-muted mb-3">Search by model number, product name, or SKU, then select a result.</p>
            <div class="position-relative mb-3">
                <label class="form-label" for="productSearch">Model No. / Product <span class="text-danger">*</span></label>
                <div class="input-group"><span class="input-group-text bg-white"><i class="bx bx-search"></i></span><input id="productSearch" class="form-control" type="search" autocomplete="off" aria-autocomplete="list" aria-expanded="false" placeholder="Search model, product name, or SKU"><button class="btn btn-outline-secondary" type="button" id="clearSearch">Clear</button></div>
                <div id="productResults" class="dropdown-menu w-100 no-dropdown" role="listbox"></div>
                <div id="searchMessage" class="no-muted small mt-2" aria-live="polite">Choose a product from the list or search by model, name, or SKU.</div>
            </div>
            <div class="no-selection">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-4"><label class="form-label" for="selectedModel">Selected model / product</label><input class="form-control" id="selectedModel" readonly placeholder="Select a product from search"></div>
                    <div class="col-6 col-md-2"><label class="form-label" for="lineQuantity">Quantity <span class="text-danger">*</span></label><input class="form-control" type="number" id="lineQuantity" min="1" max="100000" step="1" value="1"></div>
                    <div class="col-6 col-md-2"><label class="form-label" for="linePrice">Price (৳)</label><input class="form-control" id="linePrice" readonly placeholder="—"></div>
                    <div class="col-6 col-md-2"><label class="form-label" for="lineTotal">Total amount (৳)</label><input class="form-control fw-bold" id="lineTotal" readonly placeholder="—"></div>
                    <div class="col-6 col-md-2"><button type="button" class="btn btn-primary w-100" id="addItem" disabled><i class="bx bx-plus-circle"></i> <span>Add</span></button></div>
                </div>
                <div class="small no-muted mt-2" id="selectedSku"></div>
            </div>
        </section>

        <section class="no-panel">
            <h3 class="no-title">Order items</h3>
            <p class="no-muted mb-3">Edit quantity or remove products before submitting.</p>
            <div id="cartItems"><div class="no-empty">No products added yet.</div></div>
            <div class="d-flex justify-content-end border-top pt-3 mt-3"><div class="no-total">Total Amount: ৳ <span id="orderTotal">0.00</span></div></div>
            <div class="mt-3"><label class="form-label" for="orderNote">Order note <span class="text-muted">(optional)</span></label><textarea class="form-control" id="orderNote" name="notes" rows="2" maxlength="2000" placeholder="Delivery instructions or a note for our team">{{ old('notes') }}</textarea></div>
            <div id="orderPayload"></div>
        </section>
        <div class="no-submit"><a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary px-4">Cancel</a><button type="submit" id="placeOrder" class="btn btn-primary px-4" disabled>Continue to checkout</button></div>
    </form>
</div>

<script>
(() => {
    const search=document.getElementById('productSearch'),results=document.getElementById('productResults'),message=document.getElementById('searchMessage'),cart=document.getElementById('cartItems'),payload=document.getElementById('orderPayload'),submit=document.getElementById('placeOrder'),qty=document.getElementById('lineQuantity'),price=document.getElementById('linePrice'),lineTotal=document.getElementById('lineTotal'),selectedModel=document.getElementById('selectedModel'),selectedSku=document.getElementById('selectedSku'),addButton=document.getElementById('addItem');
    const items=new Map();let timer=null,query='',page=1,loading=false,hasMore=false,selected=null,editingId=null;
    const money=n=>Number(n||0).toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2});
    const closeResults=()=>{results.classList.remove('show');search.setAttribute('aria-expanded','false');};
    function updateLineTotal(){lineTotal.value=selected?money(selected.price*Math.max(1,parseInt(qty.value||'1',10))):'';}
    function selectProduct(product){selected=product;selectedModel.value=product.model||product.name;selectedSku.textContent=[product.name,product.sku?'SKU: '+product.sku:null,product.brand].filter(Boolean).join(' · ');price.value=money(product.price);qty.value='1';updateLineTotal();addButton.disabled=false;addButton.querySelector('span').textContent='Add';editingId=null;closeResults();}
    function drawResults(data,append=false){if(!append)results.innerHTML='';data.forEach(product=>{const button=document.createElement('button');button.type='button';button.className='dropdown-item no-product-option';button.setAttribute('role','option');const image=document.createElement('img');image.src=product.image;image.alt='';image.loading='lazy';const info=document.createElement('span');info.className='flex-grow-1';const name=document.createElement('strong');name.className='d-block';name.textContent=product.name;const meta=document.createElement('span');meta.className='small text-muted d-block';meta.textContent=[product.model?'Model: '+product.model:null,product.sku?'SKU: '+product.sku:null,product.brand].filter(Boolean).join(' · ');const amount=document.createElement('span');amount.className='small fw-bold d-block';amount.textContent='৳ '+money(product.price);info.append(name,meta,amount);button.append(image,info);button.addEventListener('click',()=>selectProduct(product));results.append(button);});if(hasMore){const more=document.createElement('button');more.type='button';more.className='dropdown-item text-center text-primary fw-semibold';more.textContent='Load more matching products';more.addEventListener('click',()=>loadProducts(true));results.append(more);}if(data.length||hasMore){results.classList.add('show');search.setAttribute('aria-expanded','true');}}
    async function loadProducts(next=false){if(loading)return;loading=true;message.textContent='Searching products…';try{const target=next?page+1:1;const response=await fetch(`{{ route('customer.new-order.search-products') }}?q=${encodeURIComponent(query)}&page=${target}`,{headers:{Accept:'application/json'}});if(!response.ok)throw new Error();const result=await response.json();page=target;hasMore=!!result.has_more;drawResults(result.data||[],next);message.textContent=result.data?.length?(hasMore?'Choose a product or load more results.':'Select a product from the matching results.'):'No matching products found. Try a different search.';}catch(e){message.textContent='Could not load products. Please try again.';}finally{loading=false;}}
    search.addEventListener('focus',()=>{query=search.value.trim();if(results.children.length){results.classList.add('show');search.setAttribute('aria-expanded','true');}else if(!query||query.length>=2){page=1;loadProducts(false);}});
    search.addEventListener('input',()=>{clearTimeout(timer);query=search.value.trim();results.innerHTML='';closeResults();selected=null;selectedModel.value='';selectedSku.textContent='';price.value='';lineTotal.value='';addButton.disabled=true;page=1;hasMore=false;if(!query){loadProducts(false);return;}if(query.length<2){message.textContent='Enter at least 2 characters to search products.';return;}timer=setTimeout(()=>loadProducts(false),300);});
    qty.addEventListener('input',updateLineTotal);
    document.getElementById('clearSearch').addEventListener('click',()=>{search.value='';query='';results.innerHTML='';closeResults();message.textContent='Loading products…';search.focus();});
    document.addEventListener('click',event=>{if(!results.contains(event.target)&&event.target!==search)closeResults();});
    function drawCart(){if(!items.size){cart.innerHTML='<div class="no-empty">No products added yet.</div>';payload.innerHTML='';document.getElementById('orderTotal').textContent='0.00';submit.disabled=true;return;}cart.innerHTML='';payload.innerHTML='';let total=0,index=0;items.forEach((item,id)=>{const line=item.price*item.quantity;total+=line;const row=document.createElement('div');row.className='no-line row g-2 align-items-center';const product=document.createElement('div');product.className='col-12 col-md-5';const title=document.createElement('div');title.className='no-line-title';title.textContent=item.model||item.name;const details=document.createElement('div');details.className='small no-muted';details.textContent=[item.name,item.sku?'SKU: '+item.sku:null].filter(Boolean).join(' · ');product.append(title,details);const quantity=document.createElement('div');quantity.className='col-4 col-md-2';quantity.innerHTML='<span class="small text-muted d-md-none">Quantity</span>';const qValue=document.createElement('strong');qValue.className='d-block';qValue.textContent=String(item.quantity);quantity.append(qValue);const amount=document.createElement('div');amount.className='col-5 col-md-3';amount.innerHTML='<span class="small text-muted d-md-none">Price / total</span>';const aValue=document.createElement('strong');aValue.className='d-block';aValue.textContent='৳ '+money(item.price)+' · ৳ '+money(line);amount.append(aValue);const actions=document.createElement('div');actions.className='col-3 col-md-2 d-flex justify-content-end gap-2';const edit=document.createElement('button');edit.type='button';edit.className='btn btn-sm btn-outline-primary no-action';edit.setAttribute('aria-label','Edit '+item.name);edit.textContent='Edit';edit.addEventListener('click',()=>{selected={...item};editingId=id;selectedModel.value=item.model||item.name;selectedSku.textContent=[item.name,item.sku?'SKU: '+item.sku:null].filter(Boolean).join(' · ');price.value=money(item.price);qty.value=String(item.quantity);updateLineTotal();addButton.disabled=false;addButton.querySelector('span').textContent='Update';document.getElementById('productSearch').scrollIntoView({behavior:'smooth',block:'center'});});const remove=document.createElement('button');remove.type='button';remove.className='btn btn-sm btn-outline-danger no-action';remove.setAttribute('aria-label','Remove '+item.name);remove.textContent='Remove';remove.addEventListener('click',()=>{items.delete(id);drawCart();});actions.append(edit,remove);row.append(product,quantity,amount,actions);cart.append(row);const productId=document.createElement('input');productId.type='hidden';productId.name=`items[${index}][product_id]`;productId.value=id;const itemQty=document.createElement('input');itemQty.type='hidden';itemQty.name=`items[${index}][quantity]`;itemQty.value=String(item.quantity);payload.append(productId,itemQty);index++;});document.getElementById('orderTotal').textContent=money(total);submit.disabled=false;}
    addButton.addEventListener('click',()=>{if(!selected)return;const quantity=Math.max(1,Math.min(100000,parseInt(qty.value||'1',10)));const id=String(selected.id);if(editingId!==null){items.set(String(editingId),{...items.get(String(editingId)),quantity});}else{const existing=items.get(id);if(existing)existing.quantity=Math.min(100000,existing.quantity+quantity);else items.set(id,{...selected,quantity});}selected=null;editingId=null;selectedModel.value='';selectedSku.textContent='';price.value='';lineTotal.value='';qty.value='1';addButton.disabled=true;addButton.querySelector('span').textContent='Add';drawCart();});
    document.getElementById('customerOrderForm').addEventListener('submit',event=>{if(!items.size){event.preventDefault();return;}drawCart();});
})();
</script>
@endsection
