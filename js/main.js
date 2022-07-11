//================== LOGIN 
$("#login").click(function(){
  $("#login").val("Loading ...");
  var email = document.getElementById('exampleInputEmail1').value;
  var password = document.getElementById('exampleInputPassword1').value;
  var login = true;
    $.ajax({url:"main/main.php",
    type:"GET",data:{
      login:login,email:email,password:password
    },cache:false,success:function(res){
      $("#login").val("Login");
      if (res=='success-reception') {
        window.location="reception.php";
      }else if (res=='success-hr') {
        // $("#respp").html("<span style='color:red;'>Wrong email or password ...</span>");
        window.location="hr.php";
        $("#respp").html(res);
      }else{
        $("#respp").html("<span style='color:red;'>Wrong email or password ...</span>");
      }
    }
    });
});

//================== Save Card 
$("#savelfid").click(function(){
  $("#savelfid").val("Loading ...");
  var userCode = document.getElementById('userCode').value;
  var lfid = document.getElementById('lfid').value;
  var savelfid = true;
    $.ajax({url:"main/main.php",
    type:"GET",data:{
      savelfid:savelfid,userCode:userCode,lfid:lfid
    },cache:false,success:function(res){
      if (res=='null') {
        $("#respp").html("<h2 style='color:red'>Please fill all fields ...</h2>");
      }else if(res=='failed'){
        $("#respp").html("<h2 style='color:red'>Failed</h2>");
      }else{
        $("#respp").html(res);
        // $("#respp").css("background-color","red");
      }
    }
    });
});
//================== Save Card 
$("#lfid").change(function(){
  $("#savelfid").val("Loading ...");
  var userCode = document.getElementById('userCode').value;
  var lfid = document.getElementById('lfid').value;
  var savelfid = true;
    $.ajax({url:"main/main.php",
    type:"GET",data:{
      savelfid:savelfid,userCode:userCode,lfid:lfid
    },cache:false,success:function(res){
      if (res=='null') {
        $("#respp").html("<h2 style='color:red'>Please fill all fields ...</h2>");
      }else if(res=='failed'){
        $("#respp").html("<h2 style='color:red'>Failed</h2>");
      }else{
        $("#respp").html(res);
        // $("#respp").css("background-color","red");
      }
    }
    });
});
//================== Save Card 
$("#userCode").click(function(){
  $("#respp").html("");
  $("#lfid").html("");
});


//================== SCAN CARD 
$("#scan_card").change(function(){
  var content = document.getElementById('scan_card').value;
  var scan_card = true;
    $.ajax({url:"main/main.php",
    type:"GET",data:{
      scan_card:scan_card,content:content
    },cache:false,success:function(res){
        $("#scan_card").html("");
        $("#scan_card").val("");

      if (res=='arleady') {
        $("#respp").html("<h3>already Attended ...</h3>");
      }else{
        $("#respp").html(res);
        // $("#respp").css("background-color","red");
      }
    }
    });
});

//================== Search Attendance
$("#srch_att").click(function(){
    var srchDate = document.getElementById('ddate').value;
    var srchCategoryTo = document.getElementById('ddate_to').value;
    var srchCategory = document.getElementById('att_categry').value;
    if (srchCategory=='' || srchCategory == null || srchDate=='' == null || srchCategoryTo == null) {
      alert("Please fill all forms ...");
    }else{
      var searchAtt = true;
      $.ajax({url:"main/main.php",
      type:"GET",data:{
        searchAtt:searchAtt,srchDate:srchDate,srchCategory:srchCategory,srchCategoryTo:srchCategoryTo
      },cache:false,success:function(res){
        if (res=='null') {
                alert("Please fill all forms ...");
        }else{
          $("#resspp").html(res);
          // $("#respp").css("background-color","red");
        }
      }
      });
    }
});

//================== Search Missed Attendance

$("#srch_att_missed").click(function(){
  var srchDate = document.getElementById('ddate').value;  // from
  var srchDateTo = document.getElementById('to_ddate').value;  //to
  var srchCategory = document.getElementById('att_categry').value;
  if (srchCategory=='' || srchCategory == null || srchDate=='' || srchDateTo == null) {
    alert("Please fill all forms ...");
  }else{
    var missedEmployeesBYDate = true;
    $.ajax({url:"main/main.php",
    type:"GET",data:{
      missedEmployeesBYDate:missedEmployeesBYDate,srchDate:srchDate,srchCategory:srchCategory,srchDateTo:srchDateTo
    },cache:false,success:function(res){
      if (res=='null') {
              alert("Please fill all forms ...");
      }else{
        $("#resspp").html(res);
        // $("#respp").css("background-color","red");
      }
    }
    });
  }
});