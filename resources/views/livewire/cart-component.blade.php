<div class="row cart-row">
    <div class="col-lg-8 col-md-8 col-xs-12">
        <div class="myBox-left">
            @foreach ($products as $product)
                @if ($product->product_code != 'DEFAULT001')
                    {{-- Skip default product --}}
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td rowspan="2" class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <img class="imgPrdctN"
                                        src="{{ asset('frontend/images/item_' . $product->product_code . '.jpg') }}"
                                        style="max-width:150px; width:100px;"><br><br>
                                </td>
                                <td align="left" class="bortom hidden-xs" valign="bottom" height="20%"
                                    style="padding-bottom: 10px;">
                                    {{ $product->product_name }}
                                </td>
                                <td align="right" valign="bottom" height="20%" class="bortom hiddenmobile"
                                    style="padding-bottom: 10px;">
                                    <input class="noborder-summary" disabled type="text"
                                        id="netprice_{{ $product->product_code }}"
                                        name="netprice_{{ $product->product_code }}"
                                        value="{{ $product->currency }} {{ number_format($cartItems[$product->product_code]['total'] ?? 0, 2) }}">
                                </td>
                            </tr>
                            <tr class="plm">
                                <td align="left" class="bortom visible-xs" valign="bottom" height="20%"
                                    style="padding-bottom: 10px;">
                                    {{ $product->product_name }}
                                </td>
                                <td align="left" valign="top" style="padding-top:10px;"
                                    class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <input class="noborder" disabled style="text-align:left;color:#333;" type="text"
                                        id="unitprice_{{ $product->product_code }}"
                                        name="unitprice_{{ $product->product_code }}"
                                        value="{{ $product->currency }} {{ number_format($product->unit_price, 2) }}">
                                </td>
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
