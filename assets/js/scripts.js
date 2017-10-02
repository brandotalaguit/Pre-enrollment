$(function(){
$('.remarks,.delete_remarks,.logout').tooltip({
  selector: "a[rel=tooltip]"
});
$('span').tooltip();

$('#btnConfirmSchedule').click(function(){
    $(this).attr('disabled','disabled');
});

$('#btn_submit').click(function(e){        
    e.preventDefault();  
    var cfn = $('input:radio[name=subject]:checked').val();        
    if(cfn == undefined)
    {
      alert('Please select a schedule')
    }
    else
    {
      $('#cfn').submit();
      $(this).attr('disabled','disabled');
    }
});

$('#block_sched input:radio').click(function(e){
    alert('Warning: Selecting a block schedule will delete your currently selected subjects.');
});


$('#btn_submit_block').click(function(e){        
    e.preventDefault();  
    var cfn = $('input:radio[name=subject]:checked').val();        
    if(cfn == undefined)
    {
      alert('Please select a block schedule')
    }
    else
    {          
      $('#block_sched').submit();
      $(this).attr('disabled','disabled');
    }
});


$('#btn_show').click(function(e){
    e.preventDefault();          
    $('#curriculum').slideToggle(2000,function(){ 
        if ($('#curriculum').is(':visible'))             
        {
          $('#btn_show').html('<b>Hide Curriculum</b> <i class="icon-chevron-up icon-white"></i>');
        } 
        else 
        {
          $('#btn_show').html('<b>Show Curriculum</b> <i class="icon-chevron-down icon-white"></i>');
        }
    });        
});


$('a#block').click(function(e){
  e.preventDefault();
  $('#myModalB').modal('hide');
  var urlp = this.href;
  $.ajax({
           url:urlp,
           type:'POST',                              
           beforeSend: function(){               
            },
           success: function(data) {
              $('#myModalB .modal-body').html(data);
              $('#myModalB').modal('show');
            }                   
    });
})

        

$('a.enroll').click(function(e){
  e.preventDefault();
  $('#myModal').modal('hide');
  var urlp = this.href;
  $.ajax({
           url:urlp,
           type:'POST',                              
           beforeSend: function(){               
            },
           success: function(data) {
              $('#myModal .modal-body').html(data);
              $('#myModal').modal('show');
              console.log($("#myModal input[type=radio]").length);
              if($("#myModal input[type=radio]").length == 0)
              $('#btn_submit').css('display', 'none');
              else
              $('#btn_submit').removeAttr('style');

            }                   
    });
})

$('#btn_submit_payment_method').click(function (e) {
  e.preventDefault();
  var lbp_options = $('input:radio[name=methodpayment]:checked').val();
  
  if(lbp_options == undefined)
  {
    alert('Please select a payment method')
  }
  else
  {
    if (lbp_options == 2) 
    {
      $('#landbank_payment_method').attr('target', 'blank');
      $('#myModalL').modal('hide');
      location.reload();
    }
    else
    {
      $('#landbank_payment_method').removeAttr('target');
    }

    $('#landbank_payment_method').submit();
    $(this).attr('disabled','disabled');
  }

})


window.addEventListener("keydown", keyListener, false);

function keyListener(e) {
	if(e.keyCode == 123 || e.keyCode == 120) {
		e.returnValue = false;
	}
}


}); // end onload

function getInternetExplorerVersion()
// Returns the version of Internet Explorer or a -1
// (indicating the use of another browser).
{
  var rv = -1; // Return value assumes failure.
  if (navigator.appName == 'Microsoft Internet Explorer')
  {
    var ua = navigator.userAgent;
    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
  }
  return rv;
}
function checkVersion()
{  
  var ver = getInternetExplorerVersion();

  if ( ver > -1 )
  {
    if ( ver >= 8.0 ) 
      msg = "You're using a recent copy of Internet Explorer."
    else
      msg = "You should upgrade your copy of Internet Explorer.";
  }
  alert( msg );
}


$.fn.exists = function(){
    return this.length > 0 ? this : false;
}