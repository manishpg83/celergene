<div>

    <style>
        .acc {
            font-family: 'OpenSans' !important;
            background: #fff;
            margin-bottom: 50px;
        }

        .bg-gradient {
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#00102a+0,ffffff+17&0.1+0,1+36 */
            background: -moz-linear-gradient(top, rgba(0, 16, 42, 0.1) 0%, rgba(255, 255, 255, 0.53) 17%, rgba(255, 255, 255, 1) 36%);
            /* FF3.6-15 */
            background: -webkit-linear-gradient(top, rgba(0, 16, 42, 0.1) 0%, rgba(255, 255, 255, 0.53) 17%, rgba(255, 255, 255, 1) 36%);
            /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom, rgba(0, 16, 42, 0.1) 0%, rgba(255, 255, 255, 0.53) 17%, rgba(255, 255, 255, 1) 36%);
            /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#1a00102a', endColorstr='#ffffff', GradientType=0);
            /* IE6-9 */


            width: 100%;
            height: 104px;
        }

        .banner-grad {

            height: 104px;
            text-align: left;
            color: #002b49;
            font-size: 30px;
        }

        .tab-a a.active {
            color: #000 !important;
            background: #fff;

        }

        .tab-a a {
            background: #d2d2d2;
            color: #000 !important;
            padding: 20px 30px;
            border: 1px solid #b8b8b8;
            text-decoration: none !important;
            border-bottom: none;
            float: left;
        }

        .ru {
            border-top: 1px solid #dedede;
        }

        .ro {
            border-bottom: 1px solid #dedede;
        }

        .desc {
            padding: 20px 20px;
            padding-left: 32px;
            width: 100%;
            color: #666666;
        }

        .desc .title {
            font-size: 16px;
        }

        .desc .ib {
            font-size: 14px;
        }

        .desc a {
            display: block;
            color: #002b49;
            margin-bottom: 20px;

        }

        .no-padding {
            padding-right: 0px !important;
            padding-left: 0px !important;
        }

        .head-sec {
            background: #0a639f;
            color: #fff;
            padding: 10px 20px;
        }

        .head-sec-long {
            background: #002D59;
            color: #fff;
            padding: 16px 20px;
            text-align: center;
        }

        .rba {
            border-left: 1px solid #dedede;
        }

        .rba .paddingsec {
            padding: 15px 40px;
        }

        .rba .paddingseclong {
            padding: 13px 40px;
        }


        .section .sem {
            background: #fff;
            border-bottom: 1px solid #dedede;
        }

        .section .sem-title {
            background: #D2D2D2;
        }

        .section .sem-content {
            background: #fff;
        }


        .section .sem a {
            padding: 6px 15px;
            border: 1px solid #0a639f;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            -o-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        .section .sem span {
            padding-top: 3px;
        }

        .section .sem a:hover {
            background: #0a639f;
            color: #fff;
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            -o-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        .section .act {
            background: #fff;
            border-bottom: 1px solid #dedede;
        }

        .rba .addmore {
            cursor: pointer;
            text-decoration: none;
            display: block;
        }

        .bo-op {
            border-right: 1px solid #dedede;
            border-left: 1px solid #dedede;
            border-bottom: 1px solid #dedede;
        }

        .table-res tr:nth-child(even) {
            background: #e9e9e9;
        }

        .table-res tdhead {
            background: #d2d2d2;
        }
    </style>


    <div class="wrapper-fixed acc">
        <div class="bg-gradient">
            <div class="container">
                <div class="row ro-none">
                    <div class="banner-grad">
                        <div class="table-cell">
                            <div class="v-align">
                                {{ $user->name ?? $user->first_name . ' ' . $user->last_name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-a container">
            <div class="row ro-none">
                <div class="clearfix">
                    <a class="item active" href="{{ route('myaccount') }}">
                        ACCOUNT
                    </a>
                    <a class="item" href="#transaction">
                        TRANSACTION
                    </a>
                </div>
            </div>
        </div>
        <div class="content-p">
            <div class="container bo-op">
                <div class="row ro-none">
                    <div class="col-sm-6 col-xs-12 ru bo-mob">
                        <div class="row">
                            <div class="desc ro">
                                <div class="title">
                                    Email
                                </div>
                                <div class="ib">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="desc ro">
                                <div class="title">
                                    Company
                                </div>
                                <div class="ib">
                                    {{ $user->company ?? 'Not provided' }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="desc ro">
                                <div class="title">
                                    Phone Number
                                </div>
                                <div class="ib">
                                    {{ $user->phone ?? 'Not provided' }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="desc ro">
                                <div class="title">
                                    Date of Birth
                                </div>
                                <div class="ib">
                                    {{ $user->date_of_birth ? $user->date_of_birth->format('d-m-Y') : 'Not provided' }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="desc">
                                <a href="#" title="">&gt; EDIT ACCOUNT</a>
                                <a href="#" title="">&gt; CHANGE PASSWORD</a>
                                <a href="#" title="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    &gt; LOGOUT
                                </a>
                            </div>
                        </div>
                        
                        <!-- Logout Form -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        
                    </div>
                    <div class="col-sm-6 col-xs-12 no-padding rba bo-mob2">
                        <div class="section">
                            <div class="head-sec padr">
                                BILLING INFORMATION
                            </div>
                            <div class="content padr">
                                @if ($customer)
                                    @if ($customer->billing_address)
                                        <div class="sem paddingsec clearfix">
                                            <span class="pull-left">{{ $customer->first_name }}
                                                {{ $customer->last_name }}</span>
                                            <div id="address-action-wrapper">
                                                <a href="#" wire:click="deleteBillingAddress({{ $customer->id }})"
                                                    wire:confirm="Are you sure you want to delete this billing address?"
                                                    style="margin-left:15px"
                                                    class="delete-address pull-right">delete</a>
                                                
                                                <a href="{{ route('addbillingaddress', ['id' => $customer->id]) }}"
                                                    title="" class="pull-right">edit</a>
                                            </div>
                                        </div>
                                        <div class="act paddingsec">
                                            {{ $customer->billing_address }}<br>
                                            {{ $customer->billing_country }}<br>
                                            {{ $customer->billing_postal_code }}<br>
                                            {{ $customer->mobile_number }}
                                        </div>
                                    @else
                                        <p>No billing address found.</p>
                                        <div class="content padr">
                                            <a class="addmore paddingsec" href="{{ route('addbillingaddress') }}">
                                                + ADD BILLING ADDRESS
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <p>No customer data available.</p>
                                @endif
                            </div>
                        </div>
                        <div class="section">
                            <div class="head-sec padr">
                                SHIPPING INFORMATION
                            </div>
                            <div class="content padr">
                                @if ($customer && $customer->shipping_address_receiver_name_1)
                                    <!-- First Shipping Address -->
                                    <div class="sem paddingsec clearfix">
                                        <span
                                            class="pull-left">{{ $customer->shipping_address_receiver_name_1 }}</span>
                                        <div id="address-action-wrapper">
                                            <a href="#"
                                            wire:click="deleteShippingAddress(1)"
                                            wire:confirm="Are you sure you want to delete this shipping address?"
                                            class="delete-address pull-right" style="margin-left:15px;">
                                            delete
                                         </a>
                                            <a href="{{ route('addshippingaddress', ['addressNumber' => 1]) }}"
                                                class="pull-right">edit</a>
                                        </div>
                                    </div>
                                    <div class="act paddingsec">
                                        {{ $customer->shipping_address_1 }}<br>
                                        {{ $customer->shipping_country_1 }}<br>
                                        {{ $customer->shipping_postal_code_1 }}<br>
                                    </div>

                                    <!-- Second Shipping Address -->
                                    @if ($customer->shipping_address_receiver_name_2)
                                        <div class="sem paddingsec clearfix mt-4">
                                            <span
                                                class="pull-left">{{ $customer->shipping_address_receiver_name_2 }}</span>
                                            <div id="address-action-wrapper">
                                                <a href="#"
                                                wire:click="deleteShippingAddress(2)"
                                                wire:confirm="Are you sure you want to delete this shipping address?"
                                                class="delete-address pull-right" style="margin-left:15px;">
                                                delete
                                             </a>
                                                <a href="{{ route('addshippingaddress', ['addressNumber' => 2]) }}"
                                                    class="pull-right">edit</a>
                                            </div>
                                        </div>
                                        <div class="act paddingsec">
                                            {{ $customer->shipping_address_2 }}<br>
                                            {{ $customer->shipping_country_2 }}<br>
                                            {{ $customer->shipping_postal_code_2 }}<br>
                                        </div>
                                    @endif

                                    <!-- Third Shipping Address -->
                                    @if ($customer->shipping_address_receiver_name_3)
                                        <div class="sem paddingsec clearfix mt-4">
                                            <span
                                                class="pull-left">{{ $customer->shipping_address_receiver_name_3 }}</span>
                                            <div id="address-action-wrapper">
                                                <a href="#"
                                                wire:click="deleteShippingAddress(3)"
                                                wire:confirm="Are you sure you want to delete this shipping address?"
                                                class="delete-address pull-right" style="margin-left:15px;">
                                                delete
                                             </a>
                                                <a href="{{ route('addshippingaddress', ['addressNumber' => 3]) }}"
                                                    class="pull-right">edit</a>
                                            </div>
                                        </div>
                                        <div class="act paddingsec">
                                            {{ $customer->shipping_address_3 }}<br>
                                            {{ $customer->shipping_country_3 }}<br>
                                            {{ $customer->shipping_postal_code_3 }}<br>
                                        </div>
                                    @endif
                                @else
                                    <p>No shipping address found.</p>
                                @endif

                                @if (!$customer || !$customer->shipping_address_receiver_name_3)
                                    <div class="content padr">
                                        <a class="addmore paddingsec" href="{{ route('addshippingaddress') }}">
                                            + ADD SHIPPING ADDRESS
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function confirmDelete(customerId) {
        if (confirm('Are you sure you want to delete this billing address?')) {
            Livewire.dispatch('deleteBillingAddress', {
                customerId: customerId
            });
        }
    }

    function confirmDeleteShipping(addressNumber) {
        if (confirm('Are you sure you want to delete this shipping address?')) {
            Livewire.dispatch('deleteShippingAddress', {
                addressNumber: addressNumber
            });
        }
    }
</script>
