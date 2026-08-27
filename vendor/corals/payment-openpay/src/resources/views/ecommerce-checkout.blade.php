<div class="row">
    <div class="col-md-12">
        @component('components.box')
            @slot('box_title')
                @lang('Openpay::labels.checkout.title')
            @endslot
            @php \Actions::do_action('pre_openpay_checkout_form',$gateway) @endphp

            <form id="payment-form" action="{{ url($action) }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('',
                            'Openpay::attributes.openpay.holder_name',true,
                            isset($order)?(data_get($order,'billing.billing_address.first_name'). ' '.data_get($order,'billing.billing_address.last_name')):'',
                            ['data-openpay-card'=>'holder_name', 'size'=>"50",'class'=>'']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('','Openpay::attributes.openpay.card_number',true,'',
                            ['data-openpay-card'=>'card_number', 'size'=>"50",'class'=>'only-numbers']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        {!! CoralsForm::text('','Openpay::attributes.openpay.expMonth',true,'',['placeholder'=>"MM",
                        'data-openpay-card'=>'expiration_month', 'size'=>"4",'class'=>'only-numbers']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! CoralsForm::text('','&nbsp;',false,'',['placeholder'=>"YY",
                            'data-openpay-card'=>'expiration_year', 'size'=>"4",'class'=>'only-numbers']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! CoralsForm::text('','cvv',true,'',['placeholder'=>"cvv",
                            'data-openpay-card'=>'cvv2', 'size'=>"5",'class'=>'only-numbers']) !!}
                    </div>
                </div>

                <div id="payment-error" class="alert alert-danger hidden d-none"></div>
            </form>
        @endcomponent
    </div>
</div>

<script>
    var isAjax = '{{ request()->ajax() }}';

    window.onload = function () {
        initOpenpay();
    };

    if (isAjax == '1') {
        initOpenpay();
    }

    function onlyNumbers(value) {
        return value.replace(/[^0-9]/g, '');
    }

    function initOpenpay() {
        $(document).on('keyup', '.only-numbers', function (event) {
            $(this).val(onlyNumbers($(this).val()));
        });

        OpenPay.setId("{{ $gateway->getMerchantId() }}");
        OpenPay.setApiKey("{{ $gateway->getPublicKey() }}");

        let sandbox = !!parseInt("{{ $gateway->getTestMode() }}");

        OpenPay.setSandboxMode(sandbox);

        let $form = $('#payment-form');

        let onSuccess = (response) => {
            console.log(response.data);
            $("#payment-error").addClass('hidden d-none');

            // insert the token into the form so it gets submitted to the server
            $form.append("<input type='hidden' name='checkoutToken' value='" + response.data.id + "'/>");
            $form.append("<input type='hidden' name='gateway' value='Openpay'/>");
            $form.addClass('ajax-form');
            // And submit the form.
            ajax_form($form);
        };

        let onError = (response) => {
            let message = response.message;
            let description = response.data.description;

            let paymentErrorDiv = $("#payment-error");

            paymentErrorDiv.removeClass('hidden').removeClass('d-none');
            paymentErrorDiv.html(`${message} <br/> ${description}`);

            if (window.Ladda) {
                Ladda.stopAll();
            }
        }

        $(function () {
            $form.on("submit", function (e) {
                e.preventDefault();

                OpenPay.token.extractFormAndCreate(
                    $('#payment-form'),
                    onSuccess,
                    onError
                )

                // Prevent form from submitting
                return false;
            });
        });
    }
</script>
