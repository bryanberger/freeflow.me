@extends('layouts.master')
@section('content')

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>


<style type="text/css">

@media only screen and (min-width: 768px) {
  .modal-sm {
    width: 330px;
  }
}

  .last {
    margin-bottom: 0;
  }

  .modal-footer {
    margin-top: 0;
  }

  .modal-backdrop.in {
    opacity: .70;
    filter: alpha(opacity=70);
  }

</style>

<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>



<div id="myModal" class="modal fade bs-modal-sm">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Payment Details</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12">
            <form action="#" method="post">    
              <fieldset>
                <div class='row'>
                  <div class='col-sm-6'>
                    <div class='form-group'>
                      <input class="form-control" id="user_firstname" name="user[firstname]" placeholder="First Name" required type="text" />
                    </div>
                  </div>
                  <div class='col-sm-6'>
                    <div class='form-group'>
                        <input class="form-control" id="user_lastname" name="user[lastname]" placeholder="Last Name" required type="text" />
                    </div>
                  </div>
                </div>

                <div class='row'>
                  <div class='col-sm-12'>
                    <div class="form-group">
                      <div class="input-group">
                          <input class="form-control" id="user_email" name="user[email]" placeholder="Email" required type="text" />
                          <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class='col-sm-12'>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="street" placeholder="Street" required />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
                        </div>
                    </div>
                  </div>
                </div>

                <div class='row'>
                  <div class='col-sm-4'>
                    <div class='form-group'>
                      <input class="form-control" id="user_zip" name="user[zip]" placeholder="ZIP" required type="text" />
                    </div>
                  </div>
                  <div class='col-sm-8'>
                    <div class='form-group'>
                        <input class="form-control" id="user_city" name="user[city]" placeholder="City" required type="text" />
                    </div>
                  </div>
                </div>

                <div class='row'>
                  <div class='col-sm-12'>
                    <div class='form-group last'>
                      <select class="form-control" id="user_country" name="user[country]" required></select>
                    </div>
                  </div>
                </div>
              </fieldset>

              <hr>

              <fieldset>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="user_card" name="user[card]" placeholder="Card Number"
                                autocomplete="off" pattern="\d+" required />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-credit-card"></span></span>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group">                  
                    <div class="col-sm-6">
                      <div class="form-group">
                        <div class="input-group">
                          <input type="text" class="form-control" id="user_card_expire_date" name="user[card_expire_date]" placeholder="MM / YY"
                              pattern="\d" required />
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <div class="input-group">
                          <input type="text" class="form-control" id="user_card_cv" name="user[card_cv]" placeholder="CV"
                              pattern="\d" required />
                          <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </form>  
          </div>
        </div><!-- /.modal row -->
      </div><!-- /.modal-body -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success btn-lg btn-block">Buy ($15)</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="https://checkout.stripe.com/checkout.js"></script>

<button id="customButton">Purchase</button>

<script>
  var handler = StripeCheckout.configure({
    key: "@stripeKey",
    image: '/square-image.png',
    token: function(token, args) {
      // Use the token to create the charge with a server-side script.
      console.log(token, args);
    }
  });

  document.getElementById('customButton').addEventListener('click', function(e) {
    // Open Checkout with further options
    handler.open({
      name: 'Demo Site',
      description: '2 widgets ($20.00)',
      amount: 2000,
      shippingAddress: true,
      billingAddress: false
    });
    e.preventDefault();
  });
</script>
@stop