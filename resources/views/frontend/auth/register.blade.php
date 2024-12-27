@extends('frontend.layouts.app')

@section('title', 'Home | Celergen')
@section('header', 'Home | Celergen')

@section('content')
    <div class="wrapper-fixed">
        <div class="banner">
            <div class="table-cell">
                <div class="v-align">
                    Experience Swiss Cell Therapy
                </div>
            </div>
        </div>
        <form id="registration" method="POST" action="{{ route('frontend.register') }}" class="has-validation-callback">
            <div class="form-bg">
                <div class="container ">
                    <div class="clearfix frm">
                        <div class="header-form">
                            Register for New Customer
                        </div>
                        <div class="form-item">
                            <div class="">
                                <div class="label-cons"><span>1</span> Your basic information</div>
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12 form-group">
                                        <div class="input">
                                            <input type="text" maxlength="25" data-validation="required"
                                                name="reg_firstname" id="reg_firstname" placeholder="First name"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12 form-group">
                                        <div class="input">
                                            <input type="text" maxlength="50" data-validation="required"
                                                name="reg_lastname" id="reg_lastname" placeholder="Last name"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12 form-group">
                                        <div class="input">
                                            <!-- <input type="text" data-validation="required" class="datepick" name="reg_dbo" id="reg_dbo"  placeholder="Date Of Birth"  value=""> -->
                                            <div id="dob-text">DOB :</div>
                                            <div id="select-dob">
                                                <div id="select-date">
                                                    <select name="dd" required="">
                                                        <option value="">Date</option>
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                        <option value="31">31</option>
                                                    </select>
                                                </div>
                                                <div id="select-month">
                                                    <select name="mm" required="">
                                                        <option value="">Month</option>
                                                        <option value="01">January</option>
                                                        <option value="02">February</option>
                                                        <option value="03">March</option>
                                                        <option value="04">April</option>
                                                        <option value="05">Mei</option>
                                                        <option value="06">June</option>
                                                        <option value="07">July</option>
                                                        <option value="08">August</option>
                                                        <option value="09">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">November</option>
                                                        <option value="12">December</option>
                                                    </select>
                                                </div>
                                                <div id="select-year">
                                                    <select name="yy" required="">
                                                        <option value="">Year</option>
                                                        <option value="1916">1916</option>
                                                        <option value="1917">1917</option>
                                                        <option value="1918">1918</option>
                                                        <option value="1919">1919</option>
                                                        <option value="1920">1920</option>
                                                        <option value="1921">1921</option>
                                                        <option value="1922">1922</option>
                                                        <option value="1923">1923</option>
                                                        <option value="1924">1924</option>
                                                        <option value="1925">1925</option>
                                                        <option value="1926">1926</option>
                                                        <option value="1927">1927</option>
                                                        <option value="1928">1928</option>
                                                        <option value="1929">1929</option>
                                                        <option value="1930">1930</option>
                                                        <option value="1931">1931</option>
                                                        <option value="1932">1932</option>
                                                        <option value="1933">1933</option>
                                                        <option value="1934">1934</option>
                                                        <option value="1935">1935</option>
                                                        <option value="1936">1936</option>
                                                        <option value="1937">1937</option>
                                                        <option value="1938">1938</option>
                                                        <option value="1939">1939</option>
                                                        <option value="1940">1940</option>
                                                        <option value="1941">1941</option>
                                                        <option value="1942">1942</option>
                                                        <option value="1943">1943</option>
                                                        <option value="1944">1944</option>
                                                        <option value="1945">1945</option>
                                                        <option value="1946">1946</option>
                                                        <option value="1947">1947</option>
                                                        <option value="1948">1948</option>
                                                        <option value="1949">1949</option>
                                                        <option value="1950">1950</option>
                                                        <option value="1951">1951</option>
                                                        <option value="1952">1952</option>
                                                        <option value="1953">1953</option>
                                                        <option value="1954">1954</option>
                                                        <option value="1955">1955</option>
                                                        <option value="1956">1956</option>
                                                        <option value="1957">1957</option>
                                                        <option value="1958">1958</option>
                                                        <option value="1959">1959</option>
                                                        <option value="1960">1960</option>
                                                        <option value="1961">1961</option>
                                                        <option value="1962">1962</option>
                                                        <option value="1963">1963</option>
                                                        <option value="1964">1964</option>
                                                        <option value="1965">1965</option>
                                                        <option value="1966">1966</option>
                                                        <option value="1967">1967</option>
                                                        <option value="1968">1968</option>
                                                        <option value="1969">1969</option>
                                                        <option value="1970">1970</option>
                                                        <option value="1971">1971</option>
                                                        <option value="1972">1972</option>
                                                        <option value="1973">1973</option>
                                                        <option value="1974">1974</option>
                                                        <option value="1975">1975</option>
                                                        <option value="1976">1976</option>
                                                        <option value="1977">1977</option>
                                                        <option value="1978">1978</option>
                                                        <option value="1979">1979</option>
                                                        <option value="1980">1980</option>
                                                        <option value="1981">1981</option>
                                                        <option value="1982">1982</option>
                                                        <option value="1983">1983</option>
                                                        <option value="1984">1984</option>
                                                        <option value="1985">1985</option>
                                                        <option value="1986">1986</option>
                                                        <option value="1987">1987</option>
                                                        <option value="1988">1988</option>
                                                        <option value="1989">1989</option>
                                                        <option value="1990">1990</option>
                                                        <option value="1991">1991</option>
                                                        <option value="1992">1992</option>
                                                        <option value="1993">1993</option>
                                                        <option value="1994">1994</option>
                                                        <option value="1995">1995</option>
                                                        <option value="1996">1996</option>
                                                        <option value="1997">1997</option>
                                                        <option value="1998">1998</option>
                                                        <option value="1999">1999</option>
                                                        <option value="2000">2000</option>
                                                        <option value="2001">2001</option>
                                                        <option value="2002">2002</option>
                                                        <option value="2003">2003</option>
                                                        <option value="2004">2004</option>
                                                        <option value="2005">2005</option>
                                                        <option value="2006">2006</option>
                                                        <option value="2007">2007</option>
                                                        <option value="2008">2008</option>
                                                        <option value="2009">2009</option>
                                                        <option value="2010">2010</option>
                                                        <option value="2011">2011</option>
                                                        <option value="2012">2012</option>
                                                        <option value="2013">2013</option>
                                                        <option value="2014">2014</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2017">2017</option>
                                                        <option value="2018">2018</option>
                                                        <option value="2019">2019</option>
                                                        <option value="2020">2020</option>
                                                        <option value="2021">2021</option>
                                                        <option value="2022">2022</option>
                                                        <option value="2023">2023</option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                        <option value="2026">2026</option>
                                                        <option value="2027">2027</option>
                                                        <option value="2028">2028</option>
                                                        <option value="2029">2029</option>
                                                        <option value="2030">2030</option>
                                                        <option value="2031">2031</option>
                                                        <option value="2032">2032</option>
                                                        <option value="2033">2033</option>
                                                        <option value="2034">2034</option>
                                                        <option value="2035">2035</option>
                                                        <option value="2036">2036</option>
                                                        <option value="2037">2037</option>
                                                        <option value="2038">2038</option>
                                                        <option value="2039">2039</option>
                                                        <option value="2040">2040</option>
                                                        <option value="2041">2041</option>
                                                        <option value="2042">2042</option>
                                                        <option value="2043">2043</option>
                                                        <option value="2044">2044</option>
                                                        <option value="2045">2045</option>
                                                        <option value="2046">2046</option>
                                                        <option value="2047">2047</option>
                                                        <option value="2048">2048</option>
                                                        <option value="2049">2049</option>
                                                        <option value="2050">2050</option>
                                                        <option value="2051">2051</option>
                                                        <option value="2052">2052</option>
                                                        <option value="2053">2053</option>
                                                        <option value="2054">2054</option>
                                                        <option value="2055">2055</option>
                                                        <option value="2056">2056</option>
                                                        <option value="2057">2057</option>
                                                        <option value="2058">2058</option>
                                                        <option value="2059">2059</option>
                                                        <option value="2060">2060</option>
                                                        <option value="2061">2061</option>
                                                        <option value="2062">2062</option>
                                                        <option value="2063">2063</option>
                                                        <option value="2064">2064</option>
                                                        <option value="2065">2065</option>
                                                        <option value="2066">2066</option>
                                                        <option value="2067">2067</option>
                                                        <option value="2068">2068</option>
                                                        <option value="2069">2069</option>
                                                        <option value="2070">2070</option>
                                                        <option value="2071">2071</option>
                                                        <option value="2072">2072</option>
                                                        <option value="2073">2073</option>
                                                        <option value="2074">2074</option>
                                                        <option value="2075">2075</option>
                                                        <option value="2076">2076</option>
                                                        <option value="2077">2077</option>
                                                        <option value="2078">2078</option>
                                                        <option value="2079">2079</option>
                                                        <option value="2080">2080</option>
                                                        <option value="2081">2081</option>
                                                        <option value="2082">2082</option>
                                                        <option value="2083">2083</option>
                                                        <option value="2084">2084</option>
                                                        <option value="2085">2085</option>
                                                        <option value="2086">2086</option>
                                                        <option value="2087">2087</option>
                                                        <option value="2088">2088</option>
                                                        <option value="2089">2089</option>
                                                        <option value="2090">2090</option>
                                                        <option value="2091">2091</option>
                                                        <option value="2092">2092</option>
                                                        <option value="2093">2093</option>
                                                        <option value="2094">2094</option>
                                                        <option value="2095">2095</option>
                                                        <option value="2096">2096</option>
                                                        <option value="2097">2097</option>
                                                        <option value="2098">2098</option>
                                                        <option value="2099">2099</option>
                                                        <option value="2100">2100</option>
                                                        <option value="2101">2101</option>
                                                        <option value="2102">2102</option>
                                                        <option value="2103">2103</option>
                                                        <option value="2104">2104</option>
                                                        <option value="2105">2105</option>
                                                        <option value="2106">2106</option>
                                                        <option value="2107">2107</option>
                                                        <option value="2108">2108</option>
                                                        <option value="2109">2109</option>
                                                        <option value="2110">2110</option>
                                                        <option value="2111">2111</option>
                                                        <option value="2112">2112</option>
                                                        <option value="2113">2113</option>
                                                        <option value="2114">2114</option>
                                                        <option value="2115">2115</option>
                                                        <option value="2116">2116</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-8 col-xs-12 form-group">
                                        <div class="input">
                                            <input type="text" maxlength="100" name="reg_company" id="reg_company"
                                                placeholder="Company Name (optional)" value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12 form-group">
                                        <div class="input">
                                            <input type="text" maxlength="20" name="reg_phone" id="reg_phone"
                                                data-validation="number" placeholder="Phone Number" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <hr>
                            </div>
                            <div class="form-group">
                                <div class="label-cons"><span>2</span> Your account credentials</div>
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12 form-group has-success">
                                        <div class="input">
                                            <input type="email" maxlength="50" name="reg_email" id="reg_email"
                                                data-validation="required" placeholder="Email address" value=""
                                                class="valid">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12 form-group has-success">
                                        <div class="input">
                                            <input type="password" name="reg_pass" id="reg_pass"
                                                data-validation="length,required" data-validation-length="min8"
                                                value="" placeholder="Password" class="valid">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12 form-group">
                                        <div class="input">
                                            <input type="password" name="reg_repass" id="reg_repass"
                                                data-validation="confirmation" data-validation-confirm="reg_pass"
                                                placeholder="Re-enter Password">
                                        </div>
                                    </div>
                                </div>
                                {{--  <div class="g-recaptcha" data-sitekey="6Ld7BQ4UAAAAAFoKqvRzZ89fkFHswZ2-oPyDiqpM">
                         <div style="width: 304px; height: 78px;">
                            <div><iframe title="reCAPTCHA" width="304" height="78" role="presentation" name="a-ia8iljo3gmyg" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6Ld7BQ4UAAAAAFoKqvRzZ89fkFHswZ2-oPyDiqpM&amp;co=aHR0cHM6Ly9zdG9yZS5jZWxlcmdlbnN3aXNzLmNvbTo0NDM.&amp;hl=en&amp;v=zIriijn3uj5Vpknvt_LnfNbF&amp;size=normal&amp;cb=so32snm10bs2"></iframe></div>
                            <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
                         </div>
                         <iframe style="display: none;"></iframe>
                      </div> --}}
                            </div>
                            <div class="row">
                                <hr>
                            </div>
                            <!-- <div class="text">
                          <div class="ext">
                              You can add your detail payment later or you can <a href="#" title="">click here</a> to  add it now.
                          </div>
                          </div> -->
                            <div class="text" style="margin-top: 42px;">
                                <button type="submit" name="submit" class="join" id="submitbutton">
                                    JOIN CELERGEN
                                </button>
                            </div>
                            <div class="text">
                                <div class="ext">
                                    When you click JOIN CELERGEN you are agreeing to our <a
                                        href="https://celergenswiss.com/privacy-policy" title="">Privacy Policy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
