<div class="cart-page-wrapper">
    <div id="header-title">
        <div class="container">
            <div class="header-box"></div>
            <div class="header-text" style="background-color:silver;">CART</div>
        </div>
    </div>
    <form method="post" action="checkout.php" style="font-family: 'AdelleSansW01-Regular';">
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
                            <!-- Product 1 -->
                            <table width="100%" class="mt-2 mb-4">
                                <tbody>
                                    <tr>
                                        <td rowspan="2" class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <img class="imgPrdctN" src="{{ asset('frontend/images/item_CEL.jpg') }}"
                                                style="max-width:150px; width:100px;"><br><br>
                                        </td>
                                        <td align="left" class="bortom hidden-xs" valign="bottom" height="20%"
                                            style="padding-bottom: 10px;">
                                            {{ $products[2]->product_name ?? 'Product Name' }}
                                        </td>
                                        <td align="right" valign="bottom" height="20%" class="bortom hiddenmobile"
                                            style="padding-bottom: 10px;">
                                            <input class="noborder-summary" disabled="" style="text-align:right;"
                                                type="text" id="netprice_CEL" name="netprice_CEL" value="US$ 0.00">
                                        </td>
                                    </tr>
                                    <tr class="plm">
                                        <td align="left" class="bortom visible-xs" valign="bottom" height="20%"
                                            style="padding-bottom: 10px;">
                                            {{ $products[2]->name ?? 'Product Name' }}
                                        </td>
                                        <td align="left" valign="top" style="padding-top:10px;"
                                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <input class="noborder" disabled="" style="text-align:left;color:#333;"
                                                type="text" id="unitprice_CEL" name="unitprice_CEL"
                                                value="US$ {{ number_format($products[2]->unit_price ?? 0, 2) }}">
                                        </td>
                                        <td align="right" valign="top" style="padding-top:10px;"
                                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <span class="blockk">QUANTITY :</span>
                                            <input onclick="javascript:OnQuantityChanged('-', 'CEL');" type="button"
                                                class="btn-c btn-1 btn btn-sm" value="-"
                                                style="text-align:center !important;">
                                            <input type="text" value="0" class="noborder" id="quantity_CEL"
                                                name="quantity_CEL"
                                                style="width:35px; text-align:center !important;height: 32px; background: #858585;color: #fff; outline: none;border: none;">
                                            <input type="button" class="btn btn-sm btn-c btn-2" value="+"
                                                onclick="javascript:OnQuantityChanged('+', 'CEL');"
                                                style="text-align:center;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Product 2 -->
                            <table width="100%" class="mt-2 mb-4">
                                <tbody>
                                    <tr>
                                        <td rowspan="2" class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <img class="imgPrdctN" src="{{ asset('frontend/images/item_SER.jpg') }}"
                                                style="max-width:150px; width:100px;"><br><br>
                                        </td>
                                        <td align="left" class="bortom hidden-xs" valign="bottom" height="20%"
                                            style="padding-bottom: 10px;">
                                            {{ $products[3]->product_name ?? 'Product Name' }}
                                        </td>
                                        <td align="right" valign="bottom" height="20%"
                                            class="bortom hiddenmobile" style="padding-bottom: 10px;">
                                            <input class="noborder-summary" disabled="" style="text-align:right;"
                                                type="text" id="netprice_SER" name="netprice_SER"
                                                value="US$ 0.00">
                                        </td>
                                    </tr>
                                    <tr class="plm">
                                        <td align="left" class="bortom visible-xs" valign="bottom" height="20%"
                                            style="padding-bottom: 10px;">
                                            {{ $products[3]->name ?? 'Product Name' }}
                                        </td>
                                        <td align="left" valign="top" style="padding-top:10px;"
                                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <input class="noborder" disabled=""
                                                style="text-align:left;color:#333;" type="text" id="unitprice_SER"
                                                name="unitprice_SER"
                                                value="US$ {{ number_format($products[3]->unit_price ?? 0, 2) }}">
                                        </td>
                                        <td align="right" valign="top" style="padding-top:10px;"
                                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <span class="blockk">QUANTITY :</span>
                                            <input onclick="javascript:OnQuantityChanged('-', 'SER');" type="button"
                                                class="btn-c btn-1 btn btn-sm" value="-"
                                                style="text-align:center !important;">
                                            <input type="text" value="0" class="noborder" id="quantity_SER"
                                                name="quantity_SER"
                                                style="width:35px; text-align:center !important;height: 33px; background: #858585;color: #fff; outline: none;border: none;">
                                            <input type="button" class="btn btn-sm btn-c btn-2" value="+"
                                                onclick="javascript:OnQuantityChanged('+', 'SER');"
                                                style="text-align:center;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Product 3 -->
                            <!-- Product 3 -->
                            <table width="100%" class="mt-2 mb-4">
                                <tbody>
                                    <tr>
                                        <td rowspan="2" class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <img class="imgPrdctN" src="{{ asset('frontend/images/item_PK1.jpg') }}"
                                                style="max-width:150px; width:100px;"><br><br>
                                        </td>
                                        <td align="left" class="bortom hidden-xs" valign="bottom" height="20%"
                                            style="padding-bottom: 10px;">
                                            {{ $products[4]->product_name ?? 'Product Name' }}
                                        </td>
                                        <td align="right" valign="bottom" height="20%"
                                            class="bortom hiddenmobile" style="padding-bottom: 10px;">
                                            <input class="noborder-summary" disabled="" style="text-align:right;"
                                                type="text" id="netprice_PK1" name="netprice_PK1"
                                                value="US$ 0.00">
                                        </td>
                                    </tr>
                                    <tr class="plm">
                                        <td align="left" class="bortom visible-xs" valign="bottom" height="20%"
                                            style="padding-bottom: 10px;">
                                            {{ $products[4]->name ?? 'Product Name' }}
                                        </td>
                                        <td align="left" valign="top" style="padding-top:10px;"
                                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <input class="noborder" disabled=""
                                                style="text-align:left;color:#333;" type="text" id="unitprice_PK1"
                                                name="unitprice_PK1"
                                                value="US$ {{ number_format($products[4]->unit_price ?? 0, 2) }}">
                                        </td>
                                        <td align="right" valign="top" style="padding-top:10px;"
                                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <span class="blockk">QUANTITY :</span>
                                            <input onclick="javascript:OnQuantityChanged('-', 'PK1');" type="button"
                                                class="btn-c btn-1 btn btn-sm" value="-"
                                                style="text-align:center !important;">
                                            <input type="text" value="0" class="noborder" id="quantity_PK1"
                                                name="quantity_PK1"
                                                style="width:35px; text-align:center !important;height: 33px; background: #858585;color: #fff; outline: none;border: none;">
                                            <input type="button" class="btn btn-sm btn-c btn-2" value="+"
                                                onclick="javascript:OnQuantityChanged('+', 'PK1');"
                                                style="text-align:center;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>


                        <a href="https://celergenswiss.com/order-here">
                            <div class="myText-left"><strong>CONTINUE SHOPPING</strong></div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4">
                        <div class="myBox-right">
                            <div class="section-title">ORDER SUMMARY</div>
                            <table width="100%" id="itemslist" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr
                                        style="color:#0a1f3a;text-transform:uppercase;font-family: &quot;AdelleSansW01-Regular&quot;;">
                                        <td colspan="2">
                                            Celergen
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:20px;">
                                            (<input type="text" value="0" disabled="" class="noborder"
                                                id="quantity2_CEL" name="quantity_CEL"
                                                style="width:10%; text-align:center;color:#333;">ITEMS )
                                            <input type="hidden" name="prod[]" value="CEL">
                                        </td>
                                        <td class="price">
                                            <input class="noborder" disabled="" type="text" id="netprice2_CEL"
                                                name="netprice_CEL" value="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="sparator-order-summary">&nbsp;</span></td>
                                    </tr>
                                    <tr
                                        style="color:#0a1f3a;text-transform:uppercase;font-family: &quot;AdelleSansW01-Regular&quot;;">
                                        <td colspan="2">
                                            Celergen Serum
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:20px;">
                                            (<input type="text" value="0" disabled="" class="noborder"
                                                id="quantity2_SER" name="quantity_SER"
                                                style="width:10%; text-align:center;color:#333;">ITEMS )
                                            <input type="hidden" name="prod[]" value="SER">
                                        </td>
                                        <td class="price">
                                            <input class="noborder" disabled="" type="text" id="netprice2_SER"
                                                name="netprice_SER" value="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="sparator-order-summary">&nbsp;</span></td>
                                    </tr>
                                    <tr
                                        style="color:#0a1f3a;text-transform:uppercase;font-family: &quot;AdelleSansW01-Regular&quot;;">
                                        <td colspan="2">
                                            CELERGEN &amp; SERUM ROYALE
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:20px;">
                                            (<input type="text" value="0" disabled="" class="noborder"
                                                id="quantity2_PK1" name="quantity_PK1"
                                                style="width:10%; text-align:center;color:#333;">ITEMS )
                                            <input type="hidden" name="prod[]" value="PK1">
                                        </td>
                                        <td class="price">
                                            <input class="noborder" disabled="" type="text" id="netprice2_PK1"
                                                name="netprice_PK1" value="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="sparator-order-summary">&nbsp;</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="border-collapse: collapse; width: 100%;" id="cart-summary-table">
                                <tbody>
                                    <tr>
                                        <td class="col-md-6"
                                            style="padding: 8px; text-align: left; border-bottom: 1px solid #858585;">
                                            Sub Total :
                                        </td>
                                        <td class="bortom" align="right"
                                            style="padding: 8px; text-align: right;  font-size:13px;">
                                            <input class="noborder" type="text" style="text-align:right;"
                                                id="subtotal_text" name="subtotal_text" value="US$ 0.00">
                                            <input class="noborder" type="hidden" style="text-align:right;"
                                                id="subtotal" name="subtotal" value="0">
                                            <input class="noborder" type="hidden" style="text-align:right;"
                                                id="promocode" name="promocode" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-6"
                                            style="padding: 8px; text-align: left; border-bottom: 1px solid #858585;">
                                            Shipping :
                                        </td>
                                        <td class="bortom" align="right"
                                            style="padding: 8px; text-align: right; font-size:13px;">FREE</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; text-align: left;">
                                            Order Total :
                                        </td>
                                        <td align="right" style="padding: 8px; text-align: right; font-size:13px;">
                                            <input class="noborder" style="text-align:right; font-weight:bold;"
                                                type="text" id="nettotal_text" name="nettotal_text"
                                                value="US$ 0.00">
                                            <input class="noborder" style="text-align:right; font-weight:bold;"
                                                type="hidden" id="nettotal" name="nettotal" value="0">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="paypalinfo" style="margin-top:10px;">
                            <div class="col-lg-12 col-md-12 col-sm-12" align="right">
                                <a href="{{ route('checkout') }}" class="myButton" id="submitbutton"
                                    onclick="document.forms[0].submit();">
                                    CHECKOUT &amp; PAY &gt;
                                </a>
                            </div>
                        </div>
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
    </form>
</div>
