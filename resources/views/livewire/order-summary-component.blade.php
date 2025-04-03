
<div class="myBox-right">
    <div class="section-title">ORDER SUMMARY</div>
    <table width="100%" id="itemslist" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            @foreach($products as $product)
            @if(isset($cartItems[$product->product_code]) && $cartItems[$product->product_code]['quantity'] > 0)
            <tr style="color:#0a1f3a;text-transform:uppercase;font-family: 'AdelleSansW01-Regular';">
                <td colspan="2">
                    {{ $product->product_name }}
                </td>
            </tr>
            <tr>
                <td style="padding-left:20px;">
                    ({{ $cartItems[$product->product_code]['quantity'] }} ITEMS)
                </td>
                <td class="price">
                    {{ $product->currency }} {{ number_format($cartItems[$product->product_code]['total'], 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="2"><span class="sparator-order-summary">&nbsp;</span></td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    <table style="border-collapse: collapse; width: 100%;" id="cart-summary-table">
        <tbody>
            <tr>
                <td class="col-md-6" style="padding: 8px; text-align: left; border-bottom: 1px solid #858585;">
                    Sub Total :
                </td>
                <td class="bortom" align="right" style="padding: 8px; text-align: right; font-size:13px;">
                    USD {{ number_format($subtotal, 2) }}
                </td>
            </tr>
            <tr>
                <td class="col-md-6" style="padding: 8px; text-align: left; border-bottom: 1px solid #858585;">
                    Shipping :
                </td>
                <td class="bortom" align="right" style="padding: 8px; text-align: right; font-size:13px;">FREE</td>
            </tr>
            <tr>
                <td style="padding: 8px; text-align: left;">
                    Order Total :
                </td>
                <td align="right" style="padding: 8px; text-align: right; font-size:13px;">
                    USD {{ number_format($total, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    @if($showCheckoutButton)
    <div id="paypalinfo" style="margin-top:10px;">
        <div class="col-lg-12 col-md-12 col-sm-12" align="right">
            <button 
                wire:click="attemptCheckout" 
                class="myButton @if($isCartEmpty) disabled @endif" 
                id="submitbutton"
                @if($isCartEmpty) disabled @endif
            >
                CHECKOUT & PAY >
            </button>
        </div>
    </div>
    @endif

    <style>
        .disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .myButton:disabled {
            background-color: #cccccc;
            color: #666666;
        }
    </style>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('alert', ({type, message}) => {
                alert(message);
            });
            
            // Handle clicks on disabled button (for better UX)
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('disabled')) {
                    alert('Please add items to your cart before checkout');
                }
            });
        });
    </script>
</div>