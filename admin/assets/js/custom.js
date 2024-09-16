$(document).ready(function () {
  alertify.set("notifier", "position", "top-right");
  $(document).on("click", ".increment", function () {
    var $quantityInput = $(this).closest(".qtyBox").find(".qty");
    var productId = $(this).closest(".qtyBox").find(".prodId").val();

    var currentValue = parseInt($quantityInput.val());
    if (!isNaN(currentValue)) {
      var qtyVal = currentValue + 1;
      $quantityInput.val(qtyVal);
      quantityIncDec(productId, qtyVal);
    }
  });

  $(document).on("click", ".decrement", function () {
    var $quantityInput = $(this).closest(".qtyBox").find(".qty");
    var productId = $(this).closest(".qtyBox").find(".prodId").val();

    var currentValue = parseInt($quantityInput.val());
    if (!isNaN(currentValue) && currentValue > 1) {
      var qtyVal = currentValue - 1;
      $quantityInput.val(qtyVal);
      quantityIncDec(productId, qtyVal);
    }
  });

  function quantityIncDec(prodId, qty) {
    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: {
        productIncDec: true,
        product_id: prodId,
        quantity: qty,
      },
      success: function (response) {
        var res = JSON.parse(response);
        if (res.status == 200) {
          $("#productArea").load(" #productContent");
          alertify.success(res.message);
        } else {
          $("#productArea").load(" #productContent");
          alertify.error(res.message);
        }
      },
    });
  }

  // proceed to place order button click
  $(document).on("click", ".proceedToPlace", function () {
    //console.log('proceedToPlace');
    var cphone = $("#cphone").val();
    var payment_mode = $("#payment_mode").val();
    if (payment_mode == "") {
      swal("Select Payment Mode", "Select your payment mode", "warning");
      return false;
    }

    if (cphone == "" && !$.isNumeric(cphone)) {
      swal("Entr Phone Number", "Enter Valid Phone Number", "warning");
      return false;
    }

    var data = {
      proceedToPlaceBtn: true,
      cphone: cphone,
      payment_mode: payment_mode,
    };

    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: data,
      success: function (response) {
        var res = JSON.parse(response);
        if (res.status == 200) {
          window.location.href = "order-summary.php";
        } else if (res.status == 404) {
          swal(res.message, res.message, res.status_type, {
            buttons: {
              catch: {
                text: "Add Customer",
                value: "catch",
              },
              cancel: "Cancel",
            },
          }).then((value) => {
            switch (value) {
              case "catch":
                $('#c_phone').val(cphone);
                $('#addCustomerModal').modal('show');
                //console.log('Pop the customer add model');
                break;
              default:
            }
          });
        } else {
          swal(res.message, res.message, res.status_type);
        }
      }
    });
  });

//add customers to customer db
$(document).on('click', '.saveCustomer', function() {
  var c_name = $('#c_name').val().trim();
  var c_phone = $('#c_phone').val().trim();
  var c_email = $('#c_email').val().trim();

  if (c_name !== '' && c_phone !== '') {
    if ($.isNumeric(c_phone)) {
      var data = {
        'saveCustomerBtn': true,
        'name': c_name,
        'phone': c_phone,
        'email': c_email,
      };

      $.ajax({
        type: "POST",
        url: "orders-code.php",
        data: data,
        success: function(response) {
          var res = JSON.parse(response);
          swal(res.message, "", res.status_type).then(() => {
            if (res.status == 200) {
              $('#addCustomerModal').modal('hide');
            }
          });
        },
        error: function() {
          swal("An error occurred", "Please try again later", "error");
        }
      });
    } else {
      swal("Enter a valid Phone Number", "", "warning");
    }
  } else {
    swal("Please fill in the required fields", "", "warning");
  }
});

//saveorder
$(document).on('click', '#saveOrder', function(){
  $.ajax({
    type: "POST",
    url: "orders-code.php",
    data: {
      'saveOrder': true
    },
    success: function (response) {
      var res = JSON.parse(response);
      if(res.status == 200) {
        swal(res.message, res.message, res.status_type);
        $('#orderPlaceSuccessMessage').text(res.message);
        $('#orderSuccessModal').modal('show');

      }
      else{
        swal(res.message, res.message, res.status_type);
      }
    }
  });
});
//main curly brase
});


//print bill
function printMyBillingArea(){
  var divContents = document.getElementById("myBillingArea").innerHTML;
  var a = window.open('','');
  a.document.write('<html><title>POS System in PHP</title>');
  a.document.write('<body style="font-family: fangsong;">');
  a.document.write(divContents);
  a.document.write('</body></html>');
  a.document.close();
  a.print();
}

//download PDF
window.jsPDF = window.jspdf.jsPDF;
var docPDF = new jsPDF();

function downloadPDF(invoiceNo){
  var elementHtml = document.querySelector("#myBillingArea");
  docPDF.html(elementHtml, {
    callback: function(){
      docPDF.save(invoiceNo+'.pdf');
    },
    x: 15,
    y: 15,
    width: 170,
    windowWidth: 650
  });


}
