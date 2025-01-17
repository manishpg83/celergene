<div class="cart-page-wrapper">
    <div id="header-title">
        <div class="container">
            <div class="header-box"></div>
            <div class="header-text" style="background-color:silver;">CART</div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="container" style="margin-bottom: 50px;">
            <div class="row cart-row hidden-xs">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div style="color: #333333; margin-bottom: 20px;">Buy Celergen from the following web sites
                        if
                        you reside in
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 nopadding">
                    <div class="flag">
                        <a href="http://www.celergenus.com" target="_blank">
                            <img src="https://store.celergenswiss.com/images/asset-1.png" style="height: 60px">
                            <div class="myText">UNITED STATES CUSTOMERS</div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 nopadding">
                    <div class="flag">
                        <a href="http://www.celergen.co.uk" target="_blank">
                            <img src="https://store.celergenswiss.com/images/asset-2.png" style="height: 60px">
                            <div class="myText">UNITED KINGDOM CUSTOMERS</div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 nopadding" style="visibility:hidden;">
                    <div class="flag">
                        <a href="http://www.celergen.fr" target="_blank">
                            <img src="images/asset-3.png" style="height: 60px">
                            <div class="myText">FRENCH CUSTOMERS</div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row cart-row">
                <div class="col-lg-8 col-md-8 col-xs-12">
                    <div class="myBox-left">
                        @foreach ($products as $product)
                            @if ($product->product_code != 'DEFAULT001')
                                <!-- Skip default product -->
                                <!-- Updated Product List -->
                                <table width="100%">
                                    <tbody>
                                        <tr>
                                            @php
                                                // Example images for products
                                                $productImages = [
                                                    1 => 'item_CEL.jpg',
                                                    2 => 'item_ABC.jpg',
                                                    3 => 'item_DEF.jpg',
                                                    4 => 'item_XYZ.jpg',
                                                ];
                                                // Select the image for the current product
                                                $image = $productImages[$product->id] ?? 'item_CEL.jpg'; // Default to 'item_CEL.jpg' if not found
                                            @endphp

                                            <!-- Product Image -->
                                            <td rowspan="2" class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                <img class="imgPrdctN" src="https://store.celergenswiss.com/images/item_CEL.jpg"
                                                    style="max-width:150px; width:100px;">
                                            </td>

                                            <!-- Product Name -->
                                            <td align="left" class="bortom hidden-xs" valign="bottom" height="20%"
                                                style="padding-bottom: 10px;">
                                                {{ $product->product_name }}
                                            </td>

                                            <!-- Product Price -->
                                            <td align="right" valign="bottom" height="20%"
                                                class="bortom hiddenmobile" style="padding-bottom: 10px;">
                                                <input class="noborder-summary" disabled type="text"
                                                    id="netprice_{{ $product->product_code }}"
                                                    name="netprice_{{ $product->product_code }}"
                                                    value="{{ $product->currency }} {{ number_format($cartItems[$product->product_code]['total'] ?? 0, 2) }}">
                                            </td>
                                        </tr>

                                        <tr class="plm">
                                            <!-- Product Name for Mobile -->
                                            <td align="left" class="bortom visible-xs" valign="bottom" height="20%"
                                                style="padding-bottom: 10px;">
                                                {{ $product->product_name }}
                                            </td>

                                            <!-- Product Unit Price -->
                                            <td align="left" valign="top" style="padding-top:10px;"
                                                class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <input class="noborder" disabled style="text-align:left;color:#333;"
                                                    type="text" id="unitprice_{{ $product->product_code }}"
                                                    name="unitprice_{{ $product->product_code }}"
                                                    value="{{ $product->currency }} {{ number_format($product->unit_price, 2) }}">
                                            </td>

                                            <!-- Product Quantity Control -->
                                            <td align="right" valign="top" style="padding-top:10px;"
                                                class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <span class="blockk">QUANTITY :</span>
                                                <button wire:click="decrementQuantity('{{ $product->product_code }}')"
                                                    class="btn-c btn-1 btn btn-sm">-</button>
                                                <input type="text"
                                                    value="{{ $cartItems[$product->product_code]['quantity'] ?? 0 }}"
                                                    class="noborder"
                                                    style="width:35px; text-align:center !important;height: 32px; background: #858585;color: #fff; outline: none;border: none;"
                                                    disabled>
                                                <button wire:click="incrementQuantity('{{ $product->product_code }}')"
                                                    class="btn btn-sm btn-c btn-2">+</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        @endforeach
                    </div>

                </div>

                <div class="col-xs-12 col-md-4 col-lg-4">
                    <livewire:order-summary-component :show-checkout-button="true" />
                </div>
            </div>


            <div class="row visible-xs">
                <div class="">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
