<div>
    <div id="header-title">
        <div class="container">
            <div class="header-box"></div>
            <div class="header-text" style="background-color:silver;">CART</div>
        </div>
    </div>
    <form method="post" action="checkout.php" style="font-family: 'AdelleSansW01-Regular';">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="container" style="margin-bottom: 50px;">
                <div class="row hidden-xs">
                    <div class="">
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
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-xs-12">
                        <div class="myBox-left">
                            <input type="text" value="1" style="visibility:hidden;" name="item_CEL"
                                id="item_CEL">
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td rowspan="2" class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><img
                                                class="imgPrdctN" src="https://store.celergenswiss.com/images/item_SER.jpg"
                                                style="max-width:150px; width:100px;"><br><br></td>
                                        <td align="left" class="bortom hidden-xs" valign="bottom" height="20%"
                                            style="padding-bottom: 10px;">Celergen</td>
                                        <td align="right" valign="bottom" height="20%" class="bortom hiddenmobile"
                                            style="padding-bottom: 10px;"><input class="noborder-summary" disabled=""
                                                style="text-align:right;" type="text" id="netprice_CEL"
                                                name="netprice_CEL" value="US$ 0.00"></td>
                                    </tr>
                                    <tr class="plm">
                                        {{-- <td align="left" class="bortom visible-xs" valign="bottom" height="20%"
                                            style="padding-bottom: 10px;">Celergen</td> --}}
                                        <td align="left" valign="top" style="padding-top:10px;"
                                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><input class="noborder"
                                                disabled="" style="text-align:left;color:#333;" type="text"
                                                id="unitprice_CEL" name="unitprice_CEL" value="US$ 350.00"></td>
                                        <td align="right" valign="top" style="padding-top:10px;"
                                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><span class="blockk">QUANTITY :
                                            </span><input onclick="javascript:OnQuantityChanged('-','CEL');"
                                                type="button" class="btn-c btn-1 btn btn-sm" value="-"
                                                style="text-align:center !important;"><input type="text"
                                                value="0" class="noborder" id="quantity_CEL" name="quantity_CEL"
                                                style="width:30px; text-align:center !important;height: 30px; background: #858585;color: #fff;    outline: none;border: none;"><input
                                                type="button" class="btn btn-sm btn-c btn-2" value="+"
                                                onclick="javascript:OnQuantityChanged('+','CEL')" ;=""
                                                style="text-align:center;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="text" value="0" style="visibility:hidden;" name="item_SER"
                                id="item_SER">
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td rowspan="2" class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><img
                                                class="imgPrdctN" src="https://store.celergenswiss.com/images/item_SER.jpg"
                                                style="max-width:150px; width:100px;"><br><br></td>
                                        <td align="left" class="bortom hidden-xs" valign="bottom" height="20%"
                                            style="padding-bottom: 10px;">Celergen Serum</td>
                                        <td align="right" valign="bottom" height="20%"
                                            class="bortom hiddenmobile" style="padding-bottom: 10px;"><input
                                                class="noborder-summary" disabled="" style="text-align:right;"
                                                type="text" id="netprice_SER" name="netprice_SER"
                                                value="US$ 0.00"></td>
                                    </tr>
                                    <tr class="plm">
                                        {{-- <td align="left" class="bortom visible-xs" valign="bottom" height="20%"
                                            style="padding-bottom: 10px;">Celergen Serum</td> --}}
                                        <td align="left" valign="top" style="padding-top:10px;"
                                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><input class="noborder"
                                                disabled="" style="text-align:left;color:#333;" type="text"
                                                id="unitprice_SER" name="unitprice_SER" value="US$ 270.00"></td>
                                        <td align="right" valign="top" style="padding-top:10px;"
                                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><span class="blockk">QUANTITY
                                                :
                                            </span><input onclick="javascript:OnQuantityChanged('-','SER');"
                                                type="button" class="btn-c btn-1 btn btn-sm" value="-"
                                                style="text-align:center !important;"><input type="text"
                                                value="0" class="noborder" id="quantity_SER"
                                                name="quantity_SER"
                                                style="width:30px; text-align:center !important;height: 30px; background: #858585;color: #fff;    outline: none;border: none;"><input
                                                type="button" class="btn btn-sm btn-c btn-2" value="+"
                                                onclick="javascript:OnQuantityChanged('+','SER')" ;=""
                                                style="text-align:center;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="text" value="0" style="visibility:hidden;" name="item_PK1"
                                id="item_PK1">
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td rowspan="2" class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><img
                                                class="imgPrdctN" src="https://store.celergenswiss.com/images/item_SER.jpg"
                                                style="max-width:150px; width:100px;"><br><br></td>
                                        <td align="left" class="bortom hidden-xs" valign="bottom" height="20%"
                                            style="padding-bottom: 10px;">CELERGEN &amp; SERUM ROYALE</td>
                                        <td align="right" valign="bottom" height="20%"
                                            class="bortom hiddenmobile" style="padding-bottom: 10px;"><input
                                                class="noborder-summary" disabled="" style="text-align:right;"
                                                type="text" id="netprice_PK1" name="netprice_PK1"
                                                value="US$ 0.00"></td>
                                    </tr>
                                    <tr class="plm">
                                        {{-- <td align="left" class="bortom visible-xs" valign="bottom" height="20%"
                                            style="padding-bottom: 10px;">CELERGEN &amp; SERUM ROYALE</td> --}}
                                        <td align="left" valign="top" style="padding-top:10px;"
                                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><input class="noborder"
                                                disabled="" style="text-align:left;color:#333;" type="text"
                                                id="unitprice_PK1" name="unitprice_PK1" value="US$ 620.00"></td>
                                        <td align="right" valign="top" style="padding-top:10px;"
                                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><span class="blockk">QUANTITY
                                                :
                                            </span><input onclick="javascript:OnQuantityChanged('-','PK1');"
                                                type="button" class="btn-c btn-1 btn btn-sm" value="-"
                                                style="text-align:center !important;"><input type="text"
                                                value="0" class="noborder" id="quantity_PK1"
                                                name="quantity_PK1"
                                                style="width:30px; text-align:center !important;height: 30px; background: #858585;color: #fff;    outline: none;border: none;"><input
                                                type="button" class="btn btn-sm btn-c btn-2" value="+"
                                                onclick="javascript:OnQuantityChanged('+','PK1')" ;=""
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
                                <a class="myButton" id="submitbutton" onclick="document.forms[0].submit();">
                                    CHECKOUT &amp; PAY &gt;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row visible-xs" style="margin-top: 50px">
                    <div class="">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div style="color: #333333; margin-bottom: 20px;">Buy Celergen from the following web sites
                                if
                                you reside in
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 nopadding">
                            <div class="flag">
                                <a href="http://www.celergenus.com" target="_blank">
                                    <img src="images/asset-1.png" style="height: 60px">
                                    <div class="myText">UNITED STATES CUSTOMERS</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 nopadding">
                            <div class="flag">
                                <a href="http://www.celergen.co.uk" target="_blank">
                                    <img src="images/asset-2.png" style="height: 60px">
                                    <div class="myText">UNITED KINGDOM CUSTOMERS</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 nopadding">
                            <div class="flag">
                                <a href="http://www.celergen.fr" target="_blank">
                                    <img src="images/asset-3.png" style="height: 60px">
                                    <div class="myText">FRENCH CUSTOMERS</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    var ControlArray = [
        ['bill_firstname', 'You can\'t Leave First Name empty.', '', 'info'],
        ['bill_address1', 'You can\'t Leave Billing Address1 empty.', '', ''],
        ['bill_zip', 'You can\'t Leave Postalcode Empty.', '', ''],
        ['bill_country', 'Please Select Country from List', '', ''],
        ['bill_city', 'Please Select City from List', '', ''],
        ['bill_phone', 'Please Enter Phone no.', '', ''],
        ['bill_email', 'Please Enter a valid email id.', '', ''],
        ['firstname', 'You can\'t Leave First Name empty.', '', 'info'],
        ['address1', 'You can\'t Leave Shipping Address1 empty.', '', ''],
        ['zip', 'You can\'t Leave Postalcode Empty.', '', ''],
        ['country', 'Please Select Country from List', '', ''],
        ['phone', 'Please Enter Phone no.', '', ''],
        ['email', 'Please Enter a valid email id.', '', ''],
        ['city', 'Please Select City from List', '', '']
    ];

    function SwitchAddress(ID) {
        var CurControl = $('#ship_address');
        CurControl.css("display", (ID.checked ? "none" : "block"));
    }

    function ValidateFormInputs() {
        var addSame = document.getElementById('add_same').checked;
        var CurControl = null;
        for (var i = 0; i < ControlArray.length; i++) {

            CurControl = document.getElementById(ControlArray[i][0]);
            //alert(CurControl[i][0]);
            if (CurControl != null) {

                if (ControlArray[i][0].substring(0, 3) != "bil" && addSame)
                    continue;
                if (ControlArray[i][0] == 'bill_email') {
                    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/.test(CurControl.value) == false) {
                        alert("Please key in valid email address.");
                        CurControl.focus();
                        CurControl.style.backgroundColor = '#F3F781';
                        return false;
                    }
                }
                if (CurControl.value == "" && ControlArray[i][1] != '') {
                    alert(ControlArray[i][1]);
                    CurControl.focus();
                    CurControl.style.backgroundColor = '#F3F781'; //'#F8E0F7' -- Light Pink;
                    return false;
                } else {
                    CurControl.style.backgroundColor = '#FFFFFF';
                }
            }
        }
        return true;
    }


    function UpdateTotals(mode, itembox) {
        // var cart_count_mobile = document.getElementById("mobile-cart").getElementsByTagName("span")[0];
        // var cart_count_desktop = document.getElementById("desktop-cart").getElementsByTagName("span")[0];
        var uni_a = document.getElementById('unitprice_' + itembox).value.split(" ");
        var nett_a = document.getElementById('nettotal_text').value.split(" ");
        var nett_value = parseInt(nett_a[1].replace(',', ''));
        var uni = parseInt(uni_a[1].replace(',', ''));
        console.log(nett_value);
        var qty = document.getElementById('quantity_' + itembox);
        var net = document.getElementById('netprice_' + itembox);
        var net2 = document.getElementById('netprice2_' + itembox);
        var sub_text = document.getElementById('subtotal_text');
        var nett_text = document.getElementById('nettotal_text');
        var sub = document.getElementById('subtotal');
        var nett = document.getElementById('nettotal');

        if (qty != null && uni != null && net != null && sub != null) {
            net.value = "US$ " + (parseInt(qty.value) * parseInt(uni)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g,
                "$1,");
            net2.value = "US$ " + (parseInt(qty.value) * parseInt(uni)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g,
                "$1,");
            if (mode == "+") {
                sub_text.value = nett_text.value = "US$ " + (parseInt(nett_value) + parseInt(uni)).toFixed(2).replace(
                    /(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                sub.value = nett.value = parseInt(nett_value) + parseInt(uni);

                // cart_count_desktop.innerHTML = parseInt(cart_count_desktop.innerHTML) + 1;
                // cart_count_mobile.innerHTML = parseInt(cart_count_mobile.innerHTML) + 1;
            }
            if (mode == "-") {
                sub_text.value = nett_text.value = "US$ " + (parseInt(nett_value) - parseInt(uni)).toFixed(2).replace(
                    /(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                sub.value = nett.value = parseInt(nett_value) - parseInt(uni);
                // cart_count_desktop.innerHTML = parseInt(cart_count_desktop.innerHTML) - 1;
                // cart_count_mobile.innerHTML = parseInt(cart_count_mobile.innerHTML) - 1;
            }
        }
    }

    function OnQuantityChanged(mode, itembox) {
        var qty = document.getElementById('quantity_' + itembox);
        var qty2 = document.getElementById('quantity2_' + itembox);
        var Item = document.getElementById("item_" + itembox);
        var sub = document.getElementById("submitbutton");
        if (qty != null && Item != null) {
            var qe = qty.value.split(" ");
            console.log(itembox)
            var cur = qty.value;
            if (mode == "+") {
                Item.value = qty.value = qty2.value = parseInt(cur) + 1;
                UpdateTotals(mode, itembox);
                if (sub != null)
                    sub.disabled = false;

            } else {
                if (parseInt(cur) >= 1) {
                    Item.value = qty.value = qty2.value = parseInt(cur) - 1;
                    UpdateTotals(mode, itembox);
                }
                if (parseInt(cur) - 1 == 0) {
                    //Disable Proceed
                    if (sub != null)
                        sub.disabled = true;
                }
            }

        }
    }
</script>
<script>
    function showDivs(start) {
        var div;
        while ((div = document.getElementById('div' + start)) !== false) {
            div.style.display = (div.style.display == 'none') ? '' : 'none';
            start++;
        }
    }
</script>
