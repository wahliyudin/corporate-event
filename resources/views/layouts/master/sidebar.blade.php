<aside class="app-sidebar sticky" id="sidebar">
    <div class="main-sidebar-header">
        <a href="" class="header-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
            <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
        </a>
    </div>
    <div class="main-sidebar" id="sidebar-scroll">
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <li class="slide">
                    <a href="{{ route('home') }}" class="side-menu__item">
                        <i class="bx bx-home side-menu__icon"></i>
                        <span class="side-menu__label">Home</span>
                    </a>
                </li>
                @permission('dashboard_inventory_read|dashboard_warehouse_read')
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bx-grid-alt side-menu__icon"></i>
                            <span class="side-menu__label">Dashboard</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1 force-left">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Dashboard</a>
                            </li>
                            @permission('dashboard_inventory_read')
                                <li class="slide">
                                    <a href="{{ route('dashboard.inventory.index') }}" class="side-menu__item">Inventory</a>
                                </li>
                            @endpermission
                            @permission('dashboard_warehouse_read')
                                <li class="slide">
                                    <a href="{{ route('dashboard.warehouse.index') }}" class="side-menu__item">Warehouse</a>
                                </li>
                            @endpermission
                            @permission('dashboard_procurement_read')
                                <li class="slide">
                                    <a href="{{ route('dashboard.procurement.index') }}" class="side-menu__item">Procurement</a>
                                </li>
                            @endpermission
                        </ul>
                    </li>
                @endpermission
                @permission('master_commodity_read|master_uom_read|master_storage_read|master_material_master_read|master_fuel_stock_read|master_material_stock_read|master_delivery_address_read|master_interchange_material_master_read|master_vendor_commodity_read|master_vendor_read|master_forward_purchase_agreement_read')
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bx-data side-menu__icon"></i>
                            <span class="side-menu__label">Master</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1 mega-menu force-left">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Master</a>
                            </li>
                            @permission('master_commodity_read')
                                <li class="slide">
                                    <a href="{{ route('master.commodity.index') }}" class="side-menu__item">Commodity</a>
                                </li>
                            @endpermission
                            @permission('master_uom_read')
                                <li class="slide">
                                    <a href="{{ route('master.uom.index') }}" class="side-menu__item">Uom</a>
                                </li>
                            @endpermission
                            {{-- @permission('master_storage_type_read')
                                <li class="slide">
                                    <a href="{{ route('master.storage-type.index') }}" class="side-menu__item">
                                        Storage Type
                                    </a>
                                </li>
                            @endpermission --}}
                            @permission('master_storage_read')
                                <li class="slide">
                                    <a href="{{ route('master.storage.index') }}" class="side-menu__item">
                                        Storage
                                    </a>
                                </li>
                            @endpermission
                            @permission('master_material_master_read')
                                <li class="slide">
                                    <a href="{{ route('master.material-master.index') }}" class="side-menu__item">
                                        Material Master
                                    </a>
                                </li>
                            @endpermission
                            @permission('master_fuel_stock_read')
                                <li class="slide">
                                    <a href="{{ route('master.fuel-stock.index') }}" class="side-menu__item">
                                        Fuel Stock
                                    </a>
                                </li>
                            @endpermission
                            @permission('master_material_stock_read')
                                <li class="slide">
                                    <a href="{{ route('master.material-stock.index') }}" class="side-menu__item">
                                        Material Stock
                                    </a>
                                </li>
                            @endpermission
                            @permission('master_delivery_address_read')
                                <li class="slide">
                                    <a href="{{ route('master.delivery-address.index') }}" class="side-menu__item">
                                        Delivery Address
                                    </a>
                                </li>
                            @endpermission
                            @permission('master_interchange_material_master_read')
                                <li class="slide">
                                    <a href="{{ route('master.interchange-material-master.index') }}" class="side-menu__item">
                                        Interchange Material Master
                                    </a>
                                </li>
                            @endpermission
                            @permission('master_vendor_commodity_read')
                                <li class="slide">
                                    <a href="{{ route('master.vendor-commodity.index') }}" class="side-menu__item">
                                        Vendor Commodity
                                    </a>
                                </li>
                            @endpermission
                            @permission('master_vendor_read')
                                <li class="slide">
                                    <a href="{{ route('master.vendor.index') }}" class="side-menu__item">
                                        Vendor
                                    </a>
                                </li>
                            @endpermission
                            @permission('master_forward_purchase_agreement_read')
                                <li class="slide">
                                    <a href="{{ route('master.forward-purchase-agreement.index') }}" class="side-menu__item">
                                        Forward Purchase Agreement
                                    </a>
                                </li>
                            @endpermission
                            @permission('master_purchase_request_unit_type_read')
                                <li class="slide">
                                    <a href="{{ route('master.purchase-request-unit-type.index') }}" class="side-menu__item">
                                        Purchase Request Unit Type
                                    </a>
                                </li>
                            @endpermission
                        </ul>
                    </li>
                @endpermission
                @permission('transaction_purchase_request_read|transaction_bidding_read|
                    transaction_purchase_order_read|transaction_goods_receive_read|
                    transaction_cancel_receive_read|transaction_goods_issue_plant_read|
                    transaction_goods_issue_non_plant_read|transaction_cancel_issue_plant_read|
                    transaction_recommended_order_stock_read|transaction_transfer_stock_read|
                    transaction_discrepancy_receive_read')
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="fa-regular fa-handshake side-menu__icon w-auto"></i>
                            <span class="side-menu__label">Transaction</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1 force-left">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Transaction</a>
                            </li>
                            @permission('transaction_purchase_request_read')
                                <li class="slide">
                                    <a href="{{ route('transaction.purchase-request.index') }}"
                                        class="side-menu__item">Purchase Request</a>
                                </li>
                            @endpermission
                            @permission('transaction_bidding_read')
                                <li class="slide">
                                    <a href="{{ route('transaction.bidding.index') }}" class="side-menu__item">Bidding
                                        Comparison</a>
                                </li>
                            @endpermission
                            @permission('transaction_purchase_order_read')
                                <li class="slide">
                                    <a href="{{ route('transaction.purchase-order.index') }}"
                                        class="side-menu__item">Purchase Order</a>
                                </li>
                            @endpermission
                            @permission('transaction_goods_receive_read|transaction_cancel_receive_read')
                                <li class="slide has-sub">
                                    <a href="javascript:void(0);" class="side-menu__item">Goods Receive
                                        <i class="fe fe-chevron-right side-menu__angle"></i>
                                    </a>
                                    <ul class="slide-menu child2">
                                        @permission('transaction_goods_receive_read')
                                            <li class="slide">
                                                <a href="{{ route('transaction.goods-receive.index') }}"
                                                    class="side-menu__item">Goods Receive</a>
                                            </li>
                                        @endpermission
                                        @permission('transaction_cancel_receive_read')
                                            <li class="slide">
                                                <a href="{{ route('transaction.cancel-receive.index') }}"
                                                    class="side-menu__item">Cancel Receive</a>
                                            </li>
                                        @endpermission
                                    </ul>
                                </li>
                            @endpermission
                            @permission('transaction_goods_issue_plant_read|transaction_goods_issue_non_plant_read|
                                transaction_cancel_issue_plant_read|transaction_goods_issued_transfer_read')
                                <li class="slide has-sub">
                                    <a href="javascript:void(0);" class="side-menu__item">Goods
                                        Issued
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child2">
                                        @permission('transaction_goods_issue_plant_read')
                                            <li class="slide">
                                                <a href="{{ route('transaction.goods-issue.index') }}"
                                                    class="side-menu__item">Goods Issued Plant</a>
                                            </li>
                                        @endpermission
                                        @permission('transaction_goods_issue_non_plant_read')
                                            <li class="slide">
                                                <a href="{{ route('transaction.goods-issue-non-plant.index') }}"
                                                    class="side-menu__item">Goods Issued Non Plant</a>
                                            </li>
                                        @endpermission
                                        @permission('transaction_goods_issued_transfer_read')
                                            <li class="slide">
                                                <a href="{{ route('transaction.goods-issued-transfer.index') }}"
                                                    class="side-menu__item">Goods Issued Transfer</a>
                                            </li>
                                        @endpermission
                                        @permission('transaction_cancel_issue_plant_read')
                                            <li class="slide">
                                                <a href="{{ route('transaction.cancel-issue.index') }}"
                                                    class="side-menu__item">Cancel Issued Plant</a>
                                            </li>
                                        @endpermission
                                        @permission('transaction_cancel_issue_non_plant_read')
                                            <li class="slide">
                                                <a href="{{ route('transaction.cancel-issue-non-plant.index') }}"
                                                    class="side-menu__item">Cancel Issued Non Plant</a>
                                            </li>
                                        @endpermission
                                    </ul>
                                </li>
                            @endpermission
                            @permission('transaction_goods_issued_fuel_read|transaction_transfer_fuel_read')
                                <li class="slide has-sub">
                                    <a href="javascript:void(0);" class="side-menu__item">Fuel
                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                    <ul class="slide-menu child2">
                                        @permission('transaction_goods_issued_fuel_read')
                                            <li class="slide">
                                                <a href="{{ route('transaction.goods-issued-fuel.index') }}"
                                                    class="side-menu__item">Goods Issued Fuel</a>
                                            </li>
                                        @endpermission
                                        @permission('transaction_transfer_fuel_read')
                                            <li class="slide">
                                                <a href="{{ route('transaction.transfer-fuel.index') }}"
                                                    class="side-menu__item">Transfer Fuel</a>
                                            </li>
                                        @endpermission
                                    </ul>
                                </li>
                            @endpermission
                            @permission('transaction_recommended_order_stock_read')
                                <li class="slide">
                                    <a href="{{ route('transaction.recommended-order-stock.index') }}"
                                        class="side-menu__item">Recommended Order Stock</a>
                                </li>
                            @endpermission
                            @permission('transaction_transfer_stock_read')
                                <li class="slide">
                                    <a href="{{ route('transaction.transfer-stock.index') }}"
                                        class="side-menu__item">Transfer Stock</a>
                                </li>
                            @endpermission
                            @permission('transaction_discrepancy_receive_read')
                                <li class="slide">
                                    <a href="{{ route('transaction.discrepancy-receive.index') }}"
                                        class="side-menu__item">Discrepancy Receiving</a>
                                </li>
                            @endpermission
                            @permission('transaction_credit_return_read')
                                <li class="slide">
                                    <a href="{{ route('transaction.credit-return.index') }}" class="side-menu__item">Credit
                                        Return</a>
                                </li>
                            @endpermission
                        </ul>
                    </li>
                @endpermission
                @permission('history_material_stock_read|history_fuel_stock_read')
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bx-history side-menu__icon w-auto"></i>
                            <span class="side-menu__label">History</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1 force-left">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">History</a>
                            </li>
                            @permission('history_material_stock_read')
                                <li class="slide">
                                    <a href="{{ route('history.material-stock.index') }}" class="side-menu__item">Material
                                        Stock</a>
                                </li>
                            @endpermission
                            @permission('history_fuel_stock_read')
                                <li class="slide">
                                    <a href="{{ route('history.fuel-stock.index') }}" class="side-menu__item">Fuel Stock</a>
                                </li>
                            @endpermission
                        </ul>
                    </li>
                @endpermission
                @permission('report_purchase_request_read|report_purchase_order_read|report_work_order_read|report_goods_receive_read|
                    report_goods_issue_plant_read|report_goods_issue_non_plant_read|report_stock_opname_read|report_material_master_read|
                    report_part_availability_read|report_evaluasi_suplier_read|report_fuel_stock_read|report_fuel_transaction_read|
                    report_call_demand_usage_read|report_consignment_read|report_vendor_held_stock_read')
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bxs-report side-menu__icon w-auto"></i>
                            <span class="side-menu__label">Report</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1 mega-menu force-left">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Report</a>
                            </li>
                            @permission('report_purchase_request_read')
                                <li class="slide">
                                    <a href="{{ route('report.purchase-request.index') }}" class="side-menu__item">Purchase
                                        Request</a>
                                </li>
                            @endpermission
                            @permission('report_purchase_order_read')
                                <li class="slide">
                                    <a href="{{ route('report.purchase-order.index') }}" class="side-menu__item">Purchase
                                        Order</a>
                                </li>
                            @endpermission
                            @permission('report_work_order_read')
                                <li class="slide">
                                    <a href="{{ route('report.work-order.index') }}" class="side-menu__item">Work Order</a>
                                </li>
                            @endpermission
                            @permission('report_goods_receive_read')
                                <li class="slide">
                                    <a href="{{ route('report.goods-receive.index') }}" class="side-menu__item">Goods
                                        Receive</a>
                                </li>
                            @endpermission
                            @permission('report_goods_issue_plant_read')
                                <li class="slide">
                                    <a href="{{ route('report.goods-issue-plant.index') }}" class="side-menu__item">Goods
                                        Issued Plant</a>
                                </li>
                            @endpermission
                            @permission('report_goods_issue_non_plant_read')
                                <li class="slide">
                                    <a href="{{ route('report.goods-issue-non-plant.index') }}" class="side-menu__item">Goods
                                        Issued Non Plant</a>
                                </li>
                            @endpermission
                            @permission('report_stock_opname_read')
                                <li class="slide">
                                    <a href="{{ route('report.stock-opname.index') }}" class="side-menu__item">Stock
                                        Opname</a>
                                </li>
                            @endpermission
                            @permission('report_material_master_read')
                                <li class="slide">
                                    <a href="{{ route('report.material-master.index') }}" class="side-menu__item">Material
                                        Master</a>
                                </li>
                            @endpermission
                            @permission('report_part_availability_read')
                                <li class="slide">
                                    <a href="{{ route('report.part-availability.index') }}" class="side-menu__item">Part
                                        Availability</a>
                                </li>
                            @endpermission
                            @permission('report_evaluasi_suplier_read')
                                <li class="slide">
                                    <a href="{{ route('report.evaluasi-supplier.index') }}" class="side-menu__item">Evaluasi
                                        Supplier</a>
                                </li>
                            @endpermission
                            @permission('report_fuel_stock_read')
                                <li class="slide">
                                    <a href="{{ route('report.fuel-stock.index') }}" class="side-menu__item">Fuel Stock</a>
                                </li>
                            @endpermission
                            @permission('report_fuel_transaction_read')
                                <li class="slide">
                                    <a href="{{ route('report.fuel-transaction.index') }}" class="side-menu__item">Fuel
                                        Transaction</a>
                                </li>
                            @endpermission
                            @permission('report_call_demand_usage_read')
                                <li class="slide">
                                    <a href="{{ route('report.call-demand-usage.index') }}" class="side-menu__item">Call
                                        Demand Usage</a>
                                </li>
                            @endpermission
                            @permission('report_consignment_read')
                                <li class="slide">
                                    <a href="{{ route('report.consignment.index') }}" class="side-menu__item">Consignment</a>
                                </li>
                            @endpermission
                            @permission('report_vendor_held_stock_read')
                                <li class="slide">
                                    <a href="{{ route('report.vendor-held-stock.index') }}" class="side-menu__item">Vendor
                                        Held Stock</a>
                                </li>
                            @endpermission
                        </ul>
                    </li>
                @endpermission
                @permission('setting_user_permission_read')
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bx-cog side-menu__icon"></i>
                            <span class="side-menu__label">Setting</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1 force-left">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Setting</a>
                            </li>
                            @permission('setting_approval_read')
                                <li class="slide">
                                    <a href="{{ route('setting.approval.index') }}" class="side-menu__item">Approval</a>
                                </li>
                            @endpermission
                            @permission('setting_user_permission_read')
                                <li class="slide">
                                    <a href="{{ route('setting.permission.index') }}" class="side-menu__item">User
                                        Permission</a>
                                </li>
                            @endpermission
                        </ul>
                    </li>
                @endpermission
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
    </div>
</aside>
