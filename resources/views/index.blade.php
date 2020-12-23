<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="{{asset('custom_css/index.css')}}"/>

    <title>shurjoPay Client</title>
   

  </head>

  <body>

  	

    <div class="container">
    	<div class="amount_div_style">
    		 <form class="form-horizontal" style="margin: 0 auto;width:70%" method="post" action="{{route('sp_send')}}">
	     		{{csrf_field()}}
			    <fieldset>
			        <div class="form-group">
			         
			          <div class="col-md-6">
			          	<input 
				          	id="amount"
				          	name="payamount"
				          	autocomplete="off"
				          	type="text"
				          	class="form-control input-md"
				          	required
				          	oninvalid="this.setCustomValidity('Enter Amount')"
				          	oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
				          	placeholder="Payment amount" 
				          >
			          </div>
			        </div>

			        <div class="form-group">
			          <label class="col-md-4 control-label" for="save"></label>
			          <div class="col-md-6 text-center">
			            <button type="submit" class="btn btn-success" id="submit" name="submit">Submit</button>
			          </div>
			        </div>
			    </fieldset>
	    	</form>
    	</div>
	   
	</div>	

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>