<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ProductImport;
use App\Models\ProductSync;

class DropshippingImportController extends Controller
{
    public function index()
    {
        $imports = ProductImport::with(['vendor', 'supplierProduct'])
            ->latest()
            ->paginate(10, ['*'], 'imports_page');

        $syncs = ProductSync::with(['dropshippingProduct.vendor', 'dropshippingProduct.supplierProduct'])
            ->latest()
            ->paginate(10, ['*'], 'syncs_page');

        return view('superadmin.dropshipping.imports.index', compact('imports', 'syncs'));
    }
}
